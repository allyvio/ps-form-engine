<?php

namespace App\Services;

use App\Models\CompetencyMatrix;
use App\Models\GapAnalysis;

class RecommendationService
{
    /**
     * Calculate competency fulfillment percentage and recommendation
     */
    public function calculateRecommendation($gapAnalysis)
    {
        if (!$gapAnalysis) {
            return [
                'percentage' => 0,
                'category' => 'Belum memenuhi kriteria jabatan saat ini',
                'description' => 'Data gap analysis tidak tersedia',
                'competencies_met' => 0,
                'total_required' => 0,
                'competencies_need_development' => 0
            ];
        }

        // Get competency matrix for this position
        $matrix = CompetencyMatrix::findByDepartmentFunction(
            $gapAnalysis->departemen, 
            $gapAnalysis->fungsi
        );

        if (!$matrix) {
            return [
                'percentage' => 0,
                'category' => 'Belum memenuhi kriteria jabatan saat ini',
                'description' => 'Matrix kompetensi tidak ditemukan untuk posisi ini',
                'competencies_met' => 0,
                'total_required' => 0,
                'competencies_need_development' => 0
            ];
        }

        // Get all competencies
        $competencies = [
            'risk_management', 'business_continuity', 'personnel_management',
            'global_tech_awareness', 'physical_security', 'practical_security',
            'cyber_security', 'investigation_case_mgmt', 'business_intelligence',
            'basic_intelligence', 'mass_conflict_mgmt', 'legal_compliance',
            'disaster_management', 'sar', 'assessor'
        ];

        $totalRequired = 0;
        $competenciesMet = 0;
        $competenciesNeedDevelopment = 0;

        foreach ($competencies as $competency) {
            $expectedLevel = $matrix->getExpectedLevel($competency);
            
            // Only count if this competency is required (not null)
            if ($expectedLevel !== null) {
                $totalRequired++;
                
                $actualLevel = $gapAnalysis->{$competency . '_actual'};
                
                // Check if competency meets or exceeds required level
                if ($actualLevel !== null && $actualLevel >= $expectedLevel) {
                    $competenciesMet++;
                } else {
                    $competenciesNeedDevelopment++;
                }
            }
        }

        // Calculate percentage
        $percentage = $totalRequired > 0 ? ($competenciesMet / $totalRequired) * 100 : 0;
        
        // Determine category and description
        $recommendation = $this->determineRecommendationCategory($percentage, $competenciesNeedDevelopment);

        return [
            'percentage' => round($percentage, 1),
            'category' => $recommendation['category'],
            'description' => $recommendation['description'],
            'competencies_met' => $competenciesMet,
            'total_required' => $totalRequired,
            'competencies_need_development' => $competenciesNeedDevelopment
        ];
    }

    /**
     * Determine recommendation category based on percentage
     */
    private function determineRecommendationCategory($percentage, $needDevelopment)
    {
        if ($percentage == 100) {
            return [
                'category' => 'Memenuhi kriteria jabatan saat ini',
                'description' => 'Semua kompetensi terpenuhi atau melebihi standar yang ditetapkan dan tidak ada kompetensi yang di bawah level target'
            ];
        } elseif ($percentage >= 75 && $percentage < 100) {
            return [
                'category' => 'Cukup memenuhi kriteria jabatan saat ini',
                'description' => 'Terdapat ' . $needDevelopment . ' kompetensi yang perlu dikembangkan'
            ];
        } elseif ($percentage >= 37.5 && $percentage < 75) {
            return [
                'category' => 'Kurang memenuhi kriteria jabatan saat ini',
                'description' => 'Terdapat ' . $needDevelopment . ' kompetensi yang perlu dikembangkan'
            ];
        } else {
            return [
                'category' => 'Belum memenuhi kriteria jabatan saat ini',
                'description' => 'Terdapat ' . $needDevelopment . ' kompetensi yang perlu dikembangkan'
            ];
        }
    }

    /**
     * Get recommendation color based on percentage
     */
    public function getRecommendationColor($percentage)
    {
        if ($percentage == 100) {
            return 'success'; // Green
        } elseif ($percentage >= 75) {
            return 'info'; // Blue
        } elseif ($percentage >= 37.5) {
            return 'warning'; // Yellow/Orange
        } else {
            return 'danger'; // Red
        }
    }

    /**
     * Get detailed competency breakdown for display
     */
    public function getCompetencyBreakdown($gapAnalysis)
    {
        if (!$gapAnalysis) {
            return [];
        }

        $matrix = CompetencyMatrix::findByDepartmentFunction(
            $gapAnalysis->departemen, 
            $gapAnalysis->fungsi
        );

        if (!$matrix) {
            return [];
        }

        $competencies = [
            'risk_management' => 'Risk Management',
            'business_continuity' => 'Business Continuity',
            'personnel_management' => 'Personnel Management',
            'global_tech_awareness' => 'Global & Technological Awareness',
            'physical_security' => 'Physical Security',
            'practical_security' => 'Practical Security',
            'cyber_security' => 'Cyber Security',
            'investigation_case_mgmt' => 'Investigation & Case Management',
            'business_intelligence' => 'Business Intelligence',
            'basic_intelligence' => 'Basic Intelligence',
            'mass_conflict_mgmt' => 'Mass & Conflict Management',
            'legal_compliance' => 'Legal & Compliance',
            'disaster_management' => 'Disaster Management',
            'sar' => 'SAR',
            'assessor' => 'Assessor'
        ];

        $breakdown = [];

        foreach ($competencies as $key => $name) {
            $expectedLevel = $matrix->getExpectedLevel($key);
            
            // Only include required competencies
            if ($expectedLevel !== null) {
                $actualLevel = $gapAnalysis->{$key . '_actual'};
                $isMet = $actualLevel !== null && $actualLevel >= $expectedLevel;
                
                $breakdown[] = [
                    'name' => $name,
                    'expected' => $expectedLevel,
                    'actual' => $actualLevel,
                    'is_met' => $isMet,
                    'gap' => $actualLevel !== null ? round($actualLevel - $expectedLevel, 2) : null
                ];
            }
        }

        return $breakdown;
    }
}