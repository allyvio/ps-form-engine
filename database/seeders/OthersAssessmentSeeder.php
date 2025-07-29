<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormOtherAstra;
use App\Models\Peserta;
use Carbon\Carbon;

class OthersAssessmentSeeder extends Seeder
{
    public function run()
    {
        $csvFile = storage_path('app/file_assessment/others_final.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }
        
        $this->command->info("Reading assessment data from CSV...");
        
        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle, 0, ';');
        
        // Get peserta lookup for IDs
        $pesertaLookup = Peserta::pluck('id', 'name')->toArray();
        
        $count = 0;
        
        while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
            if (empty($data[1])) continue; // Skip if no reviewer name
            
            // Extract basic info
            $submissionDate = !empty($data[0]) ? Carbon::createFromFormat('M j, Y', $data[0])->format('Y-m-d') : null;
            $reviewerName = trim($data[1]);
            $reviewerId = isset($pesertaLookup[$reviewerName]) ? $pesertaLookup[$reviewerName] : null;
            
            // Find reviewee (person being rated) from columns 2-99 (covers all "Rater:" columns)
            $revieweeName = null;
            $revieweeId = null;
            for ($i = 2; $i <= 99; $i++) {
                if (!empty($data[$i]) && trim($data[$i]) !== '') {
                    $revieweeName = trim($data[$i]);
                    $revieweeId = isset($pesertaLookup[$revieweeName]) ? $pesertaLookup[$revieweeName] : null;
                    break;
                }
            }
            
            if (!$revieweeName) continue; // Skip if no reviewee found
            
            // Extract metadata (correct column positions)
            $departemen = $data[100] ?? ''; // Departemen column 101
            $fungsi = $data[101] ?? '';     // Fungsi column 102
            $peran = $data[102] ?? '';      // Peran Saudara column 103
            
            // Generate form_id and submission_id
            $formId = $count + 1;
            $submissionId = !empty($data[count($data)-2]) ? $data[count($data)-2] : 'FORM_' . $formId;
            
            // Extract competency ratings and narratives
            $competencyData = $this->extractCompetencyData($data);
            
            // Check for duplicate before creating
            $existingRecord = FormOtherAstra::where('reviewer_id', $reviewerId)
                                           ->where('reviewee_id', $revieweeId)
                                           ->where('submission_id', $submissionId)
                                           ->first();
            
            if ($existingRecord) {
                continue; // Skip duplicate record
            }
            
            // Create record
            FormOtherAstra::create([
                'form_id' => $formId,
                'reviewer_name' => $reviewerName,
                'reviewer_id' => $reviewerId,
                'reviewee_name' => $revieweeName,
                'reviewee_id' => $revieweeId,
                'submission_date' => $submissionDate,
                'submission_id' => $submissionId,
                'departemen' => $departemen,
                'fungsi' => $fungsi,
                'peran' => $peran,
                // Risk Management
                'risk_management_rating' => $competencyData['risk_management_rating'],
                'risk_management_narrative' => $competencyData['risk_management_narrative'],
                // Business Continuity
                'business_continuity_rating' => $competencyData['business_continuity_rating'],
                'business_continuity_narrative' => $competencyData['business_continuity_narrative'],
                // Personnel Management
                'personnel_management_rating' => $competencyData['personnel_management_rating'],
                'personnel_management_narrative' => $competencyData['personnel_management_narrative'],
                // Global & Tech Awareness
                'global_tech_awareness_rating' => $competencyData['global_tech_awareness_rating'],
                'global_tech_awareness_narrative' => $competencyData['global_tech_awareness_narrative'],
                // Physical Security
                'physical_security_rating' => $competencyData['physical_security_rating'],
                'physical_security_narrative' => $competencyData['physical_security_narrative'],
                // Practical Security
                'practical_security_rating' => $competencyData['practical_security_rating'],
                'practical_security_narrative' => $competencyData['practical_security_narrative'],
                // Cyber Security
                'cyber_security_rating' => $competencyData['cyber_security_rating'],
                'cyber_security_narrative' => $competencyData['cyber_security_narrative'],
                // Investigation & Case Management
                'investigation_case_mgmt_rating' => $competencyData['investigation_case_mgmt_rating'],
                'investigation_case_mgmt_narrative' => $competencyData['investigation_case_mgmt_narrative'],
                // Business Intelligence
                'business_intelligence_rating' => $competencyData['business_intelligence_rating'],
                'business_intelligence_narrative' => $competencyData['business_intelligence_narrative'],
                // Basic Intelligence
                'basic_intelligence_rating' => $competencyData['basic_intelligence_rating'],
                'basic_intelligence_narrative' => $competencyData['basic_intelligence_narrative'],
                // Mass & Conflict Management
                'mass_conflict_mgmt_rating' => $competencyData['mass_conflict_mgmt_rating'],
                'mass_conflict_mgmt_narrative' => $competencyData['mass_conflict_mgmt_narrative'],
                // Legal & Compliance
                'legal_compliance_rating' => $competencyData['legal_compliance_rating'],
                'legal_compliance_narrative' => $competencyData['legal_compliance_narrative'],
                // Disaster Management
                'disaster_management_rating' => $competencyData['disaster_management_rating'],
                'disaster_management_narrative' => $competencyData['disaster_management_narrative'],
                // SAR
                'sar_rating' => $competencyData['sar_rating'],
                'sar_narrative' => $competencyData['sar_narrative'],
                // Assessor
                'assessor_rating' => $competencyData['assessor_rating'],
                'assessor_narrative' => $competencyData['assessor_narrative'],
            ]);
            
            $count++;
        }
        
        fclose($handle);
        
        $this->command->info("Successfully imported $count assessment records");
    }
    
    private function extractCompetencyData($data)
    {
        // Competency data starts from column 104 (index 103)
        $startCol = 103;
        $competencies = [];
        
        $competencyNames = [
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
        
        for ($i = 0; $i < 15; $i++) {
            $ratingCol = $startCol + ($i * 2);
            $narrativeCol = $startCol + ($i * 2) + 1;
            
            $rating = isset($data[$ratingCol]) ? $this->convertRatingToNumeric($data[$ratingCol]) : 0;
            $narrative = isset($data[$narrativeCol]) ? trim($data[$narrativeCol]) : '';
            
            $competencies[$competencyNames[$i] . '_rating'] = $rating;
            $competencies[$competencyNames[$i] . '_narrative'] = $narrative;
        }
        
        return $competencies;
    }
    
    private function convertRatingToNumeric($ratingText)
    {
        $ratingText = strtolower(trim($ratingText));
        
        if (strpos($ratingText, 'basic') !== false || strpos($ratingText, '(1)') !== false) return 1;
        if (strpos($ratingText, 'intermediate') !== false || strpos($ratingText, '(2)') !== false) return 2;
        if (strpos($ratingText, 'middle') !== false || strpos($ratingText, '(3)') !== false) return 3;
        if (strpos($ratingText, 'executive') !== false || strpos($ratingText, '(4)') !== false) return 4;
        if (strpos($ratingText, 'n/a') !== false) return null;
        
        return 0; // Unknown or empty
    }
}
