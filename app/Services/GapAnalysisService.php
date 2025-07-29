<?php

namespace App\Services;

use App\Models\FormOtherAstra;
use App\Models\CompetencyMatrix;
use App\Models\GapAnalysis;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GapAnalysisService
{
    // OLD Weight configuration (35%-15%-50%)
    private const OLD_WEIGHTS = [
        'atasan' => 0.35,           // 35%
        'self' => 0.15,             // 15%
        'rekan_kerja' => 0.50       // 50% total (regardless of number of reviewers)
    ];
    
    // NEW Individual Weight configuration (10%-50%-10%-10%-10%-10%)
    private const NEW_INDIVIDUAL_WEIGHTS = [
        'Atasan Langsung' => 0.10,        // 10%
        'Diri Sendiri' => 0.50,           // 50%
        'Rekan Kerja 1' => 0.10,          // 10%
        'Rekan Kerja 2' => 0.10,          // 10%
        'Bawahan Langsung 1' => 0.10,     // 10%
        'Bawahan Langsung 2' => 0.10      // 10%
    ];
    
    private const COMPETENCIES = [
        'risk_management',
        'business_continuity',
        'personnel_management',
        'global_tech_awareness',
        'physical_security',
        'practical_security',
        'cyber_security',
        'investigation_case_mgmt',
        'business_intelligence',
        'basic_intelligence',
        'mass_conflict_mgmt',
        'legal_compliance',
        'disaster_management',
        'sar',
        'assessor'
    ];
    
    /**
     * Generate gap analysis for a specific reviewee using NEW individual weighting system
     */
    public function generateGapAnalysisForReviewee($revieweeId)
    {
        return $this->generateGapAnalysisWithIndividualWeights($revieweeId);
    }
    
    /**
     * Generate gap analysis using NEW individual weighting system (10%-50%-10%-10%-10%-10%)
     */
    public function generateGapAnalysisWithIndividualWeights($revieweeId)
    {
        $reviewee = Peserta::find($revieweeId);
        if (!$reviewee) {
            throw new \Exception("Reviewee not found with ID: $revieweeId");
        }
        
        // Get reviewer assignments (single source of truth)
        $assignments = DB::table('reviewer_assignments')
            ->where('reviewee_id', $revieweeId)
            ->get()
            ->keyBy('reviewer_role');
        
        if ($assignments->isEmpty()) {
            Log::warning("No reviewer assignments found for reviewee: {$reviewee->name}");
            return null;
        }
        
        // Get all assessments for this reviewee
        $assessments = FormOtherAstra::where('reviewee_id', $revieweeId)->get();
        
        if ($assessments->isEmpty()) {
            Log::info("No assessments found for reviewee: {$reviewee->name}");
            return null;
        }
        
        // Calculate weighted actual levels using individual assignments
        $actualLevels = $this->calculateIndividualWeightedActualLevels($assignments, $assessments);
        
        // Get expected levels from matrix
        $sampleAssessment = $assessments->first();
        $expectedLevels = $this->getExpectedLevels($sampleAssessment->departemen, $sampleAssessment->fungsi);
        
        // Calculate gaps
        $gapData = $this->calculateGaps($actualLevels, $expectedLevels);
        
        // Get matrix record
        $matrix = CompetencyMatrix::findByDepartmentFunction($sampleAssessment->departemen, $sampleAssessment->fungsi);
        
        // Prepare gap analysis data
        $gapAnalysisData = [
            'assessment_id' => $sampleAssessment->id,
            'matrix_id' => $matrix ? $matrix->id : null,
            'reviewee_name' => $reviewee->name,
            'reviewee_id' => $revieweeId,
            'reviewer_name' => 'Individual Weighted', // New weighting system
            'reviewer_id' => null,
            'departemen' => $sampleAssessment->departemen,
            'fungsi' => $sampleAssessment->fungsi,
        ];
        
        // Add competency data
        foreach (self::COMPETENCIES as $competency) {
            $gapAnalysisData[$competency . '_actual'] = round($actualLevels[$competency] ?? 0, 2);
            $gapAnalysisData[$competency . '_expected'] = $expectedLevels[$competency];
            $gapAnalysisData[$competency . '_gap'] = $gapData[$competency];
        }
        
        // Calculate summary metrics
        $summaryMetrics = $this->calculateSummaryMetrics($gapData);
        $gapAnalysisData = array_merge($gapAnalysisData, $summaryMetrics);
        
        // Store or update gap analysis
        $gapAnalysis = GapAnalysis::updateOrCreate(
            ['reviewee_id' => $revieweeId],
            $gapAnalysisData
        );
        
        return $gapAnalysis;
    }
    
    /**
     * LEGACY: Generate gap analysis using OLD grouped weighting system (35%-15%-50%)
     */
    public function generateGapAnalysisWithGroupedWeights($revieweeId)
    {
        $reviewee = Peserta::find($revieweeId);
        if (!$reviewee) {
            throw new \Exception("Reviewee not found with ID: $revieweeId");
        }
        
        // Get all assessments for this reviewee
        $assessments = FormOtherAstra::where('reviewee_id', $revieweeId)->get();
        
        if ($assessments->isEmpty()) {
            Log::info("No assessments found for reviewee: {$reviewee->name}");
            return null;
        }
        
        // Group assessments by role
        $groupedAssessments = $this->groupAssessmentsByRole($assessments);
        
        // Calculate weighted actual levels using old method
        $actualLevels = $this->calculateOldWeightedActualLevels($groupedAssessments);
        
        // Get expected levels from matrix
        $sampleAssessment = $assessments->first();
        $expectedLevels = $this->getExpectedLevels($sampleAssessment->departemen, $sampleAssessment->fungsi);
        
        // Calculate gaps
        $gapData = $this->calculateGaps($actualLevels, $expectedLevels);
        
        // Get matrix record
        $matrix = CompetencyMatrix::findByDepartmentFunction($sampleAssessment->departemen, $sampleAssessment->fungsi);
        
        // Prepare gap analysis data
        $gapAnalysisData = [
            'assessment_id' => $sampleAssessment->id,
            'matrix_id' => $matrix ? $matrix->id : null,
            'reviewee_name' => $reviewee->name,
            'reviewee_id' => $revieweeId,
            'reviewer_name' => 'Multiple Reviewers', // Old grouped system
            'reviewer_id' => null,
            'departemen' => $sampleAssessment->departemen,
            'fungsi' => $sampleAssessment->fungsi,
        ];
        
        // Add competency data
        foreach (self::COMPETENCIES as $competency) {
            $gapAnalysisData[$competency . '_actual'] = round($actualLevels[$competency] ?? 0, 2);
            $gapAnalysisData[$competency . '_expected'] = $expectedLevels[$competency];
            $gapAnalysisData[$competency . '_gap'] = $gapData[$competency];
        }
        
        // Calculate summary metrics
        $summaryMetrics = $this->calculateSummaryMetrics($gapData);
        $gapAnalysisData = array_merge($gapAnalysisData, $summaryMetrics);
        
        // Store or update gap analysis
        $gapAnalysis = GapAnalysis::updateOrCreate(
            ['reviewee_id' => $revieweeId],
            $gapAnalysisData
        );
        
        return $gapAnalysis;
    }
    
    /**
     * Group assessments by role type
     */
    private function groupAssessmentsByRole($assessments)
    {
        $grouped = [
            'self' => collect(),
            'atasan' => collect(),
            'rekan_kerja' => collect(),
        ];
        
        foreach ($assessments as $assessment) {
            // Check if this is self assessment
            if ($assessment->reviewer_name === $assessment->reviewee_name) {
                $grouped['self']->push($assessment);
            } elseif (strtolower($assessment->peran) === 'atasan') {
                $grouped['atasan']->push($assessment);
            } elseif (in_array(strtolower($assessment->peran), ['rekan kerja', 'bawahan'])) {
                // Treat both "Rekan Kerja" and "Bawahan" as peer assessments
                $grouped['rekan_kerja']->push($assessment);
            }
        }
        
        return $grouped;
    }
    
    /**
     * Calculate weighted actual levels using NEW individual weighting system
     */
    private function calculateIndividualWeightedActualLevels($assignments, $assessments)
    {
        $actualLevels = [];
        
        foreach (self::COMPETENCIES as $competency) {
            $weightedSum = 0;
            $totalWeight = 0;
            $missingWeights = 0;
            $selfMissing = false;
            
            // Process each assigned role
            foreach (self::NEW_INDIVIDUAL_WEIGHTS as $role => $baseWeight) {
                $assignment = $assignments->get($role);
                
                if ($assignment) {
                    // Find assessment for this specific reviewer
                    $assessment = $assessments->where('reviewer_id', $assignment->reviewer_id)->first();
                    
                    if ($assessment && $assessment->{$competency . '_rating'} !== null) {
                        // Assessment exists - use base weight
                        $rating = $assessment->{$competency . '_rating'};
                        $weightedSum += $rating * $baseWeight;
                        $totalWeight += $baseWeight;
                    } else {
                        // Assessment missing - track for redistribution
                        if ($role === 'Diri Sendiri') {
                            $selfMissing = true;
                        } else {
                            $missingWeights += $baseWeight;
                        }
                    }
                }
            }
            
            // Redistribute missing weights to "Diri Sendiri" if it exists and has assessment
            if ($missingWeights > 0 && !$selfMissing) {
                $selfAssignment = $assignments->get('Diri Sendiri');
                if ($selfAssignment) {
                    $selfAssessment = $assessments->where('reviewer_id', $selfAssignment->reviewer_id)->first();
                    if ($selfAssessment && $selfAssessment->{$competency . '_rating'} !== null) {
                        // Add redistributed weight to self
                        $selfRating = $selfAssessment->{$competency . '_rating'};
                        $weightedSum += $selfRating * $missingWeights;
                        $totalWeight += $missingWeights;
                    }
                }
            }
            
            $actualLevels[$competency] = $weightedSum;
        }
        
        return $actualLevels;
    }
    
    /**
     * LEGACY: Calculate weighted actual levels using OLD grouped weighting system
     */
    private function calculateOldWeightedActualLevels($groupedAssessments)
    {
        $actualLevels = [];
        
        foreach (self::COMPETENCIES as $competency) {
            $weightedSum = 0;
            
            // Self assessment (15%)
            $selfRating = $groupedAssessments['self']->isNotEmpty() 
                ? $groupedAssessments['self']->avg($competency . '_rating') ?: 0 
                : 0;
            $weightedSum += $selfRating * self::OLD_WEIGHTS['self'];
            
            // Atasan assessment (35%)
            $atasanRating = $groupedAssessments['atasan']->isNotEmpty() 
                ? $groupedAssessments['atasan']->avg($competency . '_rating') ?: 0 
                : 0;
            $weightedSum += $atasanRating * self::OLD_WEIGHTS['atasan'];
            
            // Rekan Kerja assessments (50% total, regardless of number of reviewers)
            $rekanKerjaRating = $groupedAssessments['rekan_kerja']->isNotEmpty() 
                ? $groupedAssessments['rekan_kerja']->avg($competency . '_rating') ?: 0 
                : 0;
            $weightedSum += $rekanKerjaRating * self::OLD_WEIGHTS['rekan_kerja'];
            
            // Calculate final weighted sum (always based on 100% = 0.35 + 0.15 + 0.50)
            $actualLevels[$competency] = $weightedSum;
        }
        
        return $actualLevels;
    }
    
    /**
     * Get expected levels from competency matrix
     */
    private function getExpectedLevels($departemen, $fungsi)
    {
        $matrix = CompetencyMatrix::findByDepartmentFunction($departemen, $fungsi);
        
        if (!$matrix) {
            Log::warning("No competency matrix found for: $departemen / $fungsi");
            return array_fill_keys(self::COMPETENCIES, null);
        }
        
        return $matrix->getAllExpectedLevels();
    }
    
    /**
     * Calculate gaps (expected - actual)
     */
    private function calculateGaps($actualLevels, $expectedLevels)
    {
        $gaps = [];
        
        foreach (self::COMPETENCIES as $competency) {
            $actual = $actualLevels[$competency] ?? 0;
            $expected = $expectedLevels[$competency];
            
            // Gap = Actual - Expected (positive means above expectation, negative means below expectation)
            $gaps[$competency] = $expected !== null ? round($actual - $expected, 2) : null;
        }
        
        return $gaps;
    }
    
    /**
     * Calculate summary metrics
     */
    private function calculateSummaryMetrics($gapData)
    {
        $validGaps = array_filter($gapData, function($gap) {
            return $gap !== null;
        });
        
        if (empty($validGaps)) {
            return [
                'total_gaps_below' => 0,
                'total_gaps_above' => 0,
                'total_gaps_equal' => 0,
                'overall_gap_score' => null
            ];
        }
        
        $gapsBelow = count(array_filter($validGaps, function($gap) { return $gap < 0; })); // Negative gap = below expectation
        $gapsAbove = count(array_filter($validGaps, function($gap) { return $gap > 0; })); // Positive gap = above expectation
        $gapsEqual = count(array_filter($validGaps, function($gap) { return $gap == 0; })); // Zero gap = meets expectation
        
        $overallGapScore = array_sum($validGaps) / count($validGaps);
        
        return [
            'total_gaps_below' => $gapsBelow,
            'total_gaps_above' => $gapsAbove,
            'total_gaps_equal' => $gapsEqual,
            'overall_gap_score' => round($overallGapScore, 2)
        ];
    }
    
    /**
     * Generate gap analysis for all reviewees
     */
    public function generateGapAnalysisForAll()
    {
        $revieweeIds = FormOtherAstra::distinct('reviewee_id')
                                   ->whereNotNull('reviewee_id')
                                   ->pluck('reviewee_id');
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($revieweeIds as $revieweeId) {
            try {
                $this->generateGapAnalysisForReviewee($revieweeId);
                $successCount++;
            } catch (\Exception $e) {
                Log::error("Failed to generate gap analysis for reviewee ID $revieweeId: " . $e->getMessage());
                $errorCount++;
            }
        }
        
        return [
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'total_processed' => $successCount + $errorCount
        ];
    }
}