<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormOtherAstra;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class SelfAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Reading self assessment data from CSV...\n";
        
        $filePath = storage_path('app/file_assessment/self_final.csv');
        
        if (!file_exists($filePath)) {
            echo "Error: self_final.csv not found at $filePath\n";
            return;
        }
        
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Get participant names from header (row 2)
        $header = str_getcsv($lines[1]);
        $participants = array_slice($header, 1); // Remove first empty column
        
        // Competency mapping to database field names
        $competencyMapping = [
            'Risk Management' => 'risk_management',
            'Business Continuity' => 'business_continuity',
            'Personnel Management' => 'personnel_management',
            'Global & Technological Awareness' => 'global_tech_awareness',
            'Physical Security' => 'physical_security',
            'Practical Security' => 'practical_security',
            'Cyber Security' => 'cyber_security',
            'Investigation & Case Management' => 'investigation_case_mgmt',
            'Business Intelligence' => 'business_intelligence',
            'Basic Intelligence' => 'basic_intelligence',
            'Mass & Conflict Management' => 'mass_conflict_mgmt',
            'Legal & Compliance' => 'legal_compliance',
            'Disaster Management' => 'disaster_management',
            'Search and Rescue (SAR)' => 'sar',
            'Assessor' => 'assessor'
        ];
        
        $successCount = 0;
        $skipCount = 0;
        
        // Process each participant
        foreach ($participants as $colIndex => $participantName) {
            $participantName = trim($participantName);
            if (empty($participantName)) continue;
            
            // Find participant in database
            $peserta = Peserta::where('name', $participantName)->first();
            if (!$peserta) {
                echo "Warning: Participant '$participantName' not found in database\n";
                $skipCount++;
                continue;
            }
            
            // Check if self assessment already exists
            $existingSelf = FormOtherAstra::where('reviewee_id', $peserta->id)
                                        ->where('reviewer_id', $peserta->id)
                                        ->where('peran', 'Diri Sendiri')
                                        ->first();
            
            if ($existingSelf) {
                echo "⚠️  Self assessment already exists for: $participantName, updating...\n";
                // Continue to update existing record
            }
            
            // Get department and function from reviewer_assignments or existing data
            $assignment = DB::table('reviewer_assignments')
                ->where('reviewee_id', $peserta->id)
                ->where('reviewer_role', 'Diri Sendiri')
                ->first();
                
            // If no assignment found, try to get from existing assessments
            if (!$assignment) {
                $existingAssessment = FormOtherAstra::where('reviewee_id', $peserta->id)
                    ->whereNotNull('departemen')
                    ->whereNotNull('fungsi')
                    ->first();
                $departemen = $existingAssessment ? $existingAssessment->departemen : 'Unknown';
                $fungsi = $existingAssessment ? $existingAssessment->fungsi : 'Unknown';
            } else {
                // For self assignment, we need to get dept/function from other assessments
                $existingAssessment = FormOtherAstra::where('reviewee_id', $peserta->id)
                    ->whereNotNull('departemen')
                    ->whereNotNull('fungsi')
                    ->first();
                $departemen = $existingAssessment ? $existingAssessment->departemen : 'Unknown';
                $fungsi = $existingAssessment ? $existingAssessment->fungsi : 'Unknown';
            }
            
            // Prepare self assessment data
            $assessmentData = [
                'form_id' => 9999 + $peserta->id, // Unique form_id for self assessments
                'departemen' => $departemen,
                'fungsi' => $fungsi,
                'peran' => 'Diri Sendiri',
                'reviewer_name' => $peserta->name,
                'reviewer_id' => $peserta->id,
                'reviewee_name' => $peserta->name,
                'reviewee_id' => $peserta->id,
                'submission_date' => '2025-02-28', // Same date as other assessments
                'submission_id' => 'SELF_' . $peserta->id . '_' . time(),
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            // Extract competency ratings from CSV
            $hasValidData = false;
            for ($rowIndex = 2; $rowIndex < count($lines); $rowIndex++) {
                $rowData = str_getcsv($lines[$rowIndex]);
                $competencyName = trim($rowData[0]);
                
                if (isset($competencyMapping[$competencyName])) {
                    $fieldName = $competencyMapping[$competencyName];
                    $rating = isset($rowData[$colIndex + 1]) ? trim($rowData[$colIndex + 1]) : 'N/A';
                    
                    // Convert rating to integer or null
                    if ($rating === 'N/A' || $rating === '') {
                        $assessmentData[$fieldName . '_rating'] = null;
                    } else {
                        $assessmentData[$fieldName . '_rating'] = (int)$rating;
                        $hasValidData = true;
                    }
                    $assessmentData[$fieldName . '_narrative'] = '';
                }
            }
            
            // Only insert if has at least some valid data
            if ($hasValidData) {
                if ($existingSelf) {
                    $existingSelf->update($assessmentData);
                    echo "✓ Self assessment updated for: $participantName\n";
                } else {
                    FormOtherAstra::create($assessmentData);
                    echo "✓ Self assessment created for: $participantName\n";
                }
                $successCount++;
            } else {
                echo "✗ No valid data for: $participantName\n";
                $skipCount++;
            }
        }
        
        echo "\n=== Self Assessment Import Summary ===\n";
        echo "Successfully imported: $successCount self assessments\n";
        echo "Skipped: $skipCount records\n";
        echo "Total participants processed: " . count($participants) . "\n";
    }
}
