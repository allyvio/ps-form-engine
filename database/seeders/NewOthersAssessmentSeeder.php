<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormOtherAstra;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewOthersAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Importing new others assessment data from CSV...\n";
        
        $filePath = storage_path('app/file_assessment/new_others.csv');
        
        if (!file_exists($filePath)) {
            echo "Error: new_others.csv not found at $filePath\n";
            return;
        }
        
        // Clear existing data
        FormOtherAstra::truncate();
        echo "Cleared existing form_other_astras data\n";
        
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Skip header row
        array_shift($lines);
        
        $successCount = 0;
        $skipCount = 0;
        $errors = [];
        
        // Valid functions from competency matrix
        $validFunctions = [
            'Analyst', 'Officer', 'Sector Head', 'Security Coordinator', 
            'Protocol', 'Protocol Coordinator', 'Department Head', 
            'Rescue Coordinator', 'Rescue (Anggota SAR)', 'Dantim SAR'
        ];
        
        foreach ($lines as $lineNum => $line) {
            $lineNum += 2; // Adjust for header and 0-based index
            
            // Skip empty lines
            if (empty(trim($line))) {
                echo "Skipping empty line $lineNum\n";
                $skipCount++;
                continue;
            }
            
            $data = str_getcsv($line, ';');
            
            // Skip if not enough columns
            if (count($data) < 36) {
                echo "Skipping incomplete line $lineNum (only " . count($data) . " columns)\n";
                $skipCount++;
                continue;
            }
            
            try {
                // Extract basic info
                $submissionDate = $this->parseDate($data[0]);
                $reviewerName = trim($data[1]);
                $revieweeName = trim($data[2]);
                $departemen = trim($data[3]);
                $fungsi = trim($data[4]);
                $submissionId = trim($data[35] ?? '');
                
                // Skip if missing critical data
                if (empty($reviewerName) || empty($revieweeName) || empty($submissionId)) {
                    echo "Skipping line $lineNum: missing critical data\n";
                    $skipCount++;
                    continue;
                }
                
                // Skip if function is not valid (data corruption)
                if (!in_array($fungsi, $validFunctions)) {
                    echo "Skipping line $lineNum: invalid function '$fungsi'\n";
                    $skipCount++;
                    continue;
                }
                
                // Find reviewer and reviewee IDs
                $reviewer = Peserta::where('name', $reviewerName)->first();
                $reviewee = Peserta::where('name', $revieweeName)->first();
                
                if (!$reviewee) {
                    echo "Warning: Reviewee '$revieweeName' not found in peserta table (line $lineNum)\n";
                }
                
                // Get role from reviewer_assignments
                $assignment = DB::table('reviewer_assignments')
                    ->where('reviewer_name', $reviewerName)
                    ->where('reviewee_name', $revieweeName)
                    ->first();
                
                $peran = $assignment ? $assignment->reviewer_role : 'Unknown';
                
                // Extract competency ratings (skip narrative columns)
                $competencyRatings = [
                    'risk_management_rating' => $this->parseRating($data[5] ?? ''),
                    'business_continuity_rating' => $this->parseRating($data[7] ?? ''),
                    'personnel_management_rating' => $this->parseRating($data[9] ?? ''),
                    'global_tech_awareness_rating' => $this->parseRating($data[11] ?? ''),
                    'physical_security_rating' => $this->parseRating($data[13] ?? ''),
                    'practical_security_rating' => $this->parseRating($data[15] ?? ''),
                    'cyber_security_rating' => $this->parseRating($data[17] ?? ''),
                    'investigation_case_mgmt_rating' => $this->parseRating($data[19] ?? ''),
                    'business_intelligence_rating' => $this->parseRating($data[21] ?? ''),
                    'basic_intelligence_rating' => $this->parseRating($data[23] ?? ''),
                    'mass_conflict_mgmt_rating' => $this->parseRating($data[25] ?? ''),
                    'legal_compliance_rating' => $this->parseRating($data[27] ?? ''),
                    'disaster_management_rating' => $this->parseRating($data[29] ?? ''),
                    'sar_rating' => $this->parseRating($data[31] ?? ''),
                    'assessor_rating' => $this->parseRating($data[33] ?? ''),
                ];
                
                // Prepare assessment data
                $assessmentData = [
                    'form_id' => substr($submissionId, -8), // Use last 8 digits as form_id
                    'submission_date' => $submissionDate,
                    'submission_id' => $submissionId,
                    'reviewer_name' => $reviewerName,
                    'reviewer_id' => $reviewer ? $reviewer->id : null,
                    'reviewee_name' => $revieweeName,
                    'reviewee_id' => $reviewee ? $reviewee->id : null,
                    'departemen' => $departemen,
                    'fungsi' => $fungsi,
                    'peran' => $peran,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                // Add competency ratings (narratives set to empty)
                foreach ($competencyRatings as $competency => $rating) {
                    $assessmentData[$competency] = $rating;
                    $assessmentData[str_replace('_rating', '_narrative', $competency)] = '';
                }
                
                // Check for duplicates
                $existing = FormOtherAstra::where('submission_id', $submissionId)->first();
                
                if ($existing) {
                    echo "⚠️  Duplicate submission ID $submissionId, updating...\n";
                    $existing->update($assessmentData);
                } else {
                    FormOtherAstra::create($assessmentData);
                    echo "✓ Created: $reviewerName → $revieweeName ($peran)\n";
                }
                
                $successCount++;
                
            } catch (\Exception $e) {
                $error = "Error processing line $lineNum: " . $e->getMessage();
                echo "✗ $error\n";
                $errors[] = $error;
                $skipCount++;
            }
        }
        
        echo "\n=== Import Summary ===\n";
        echo "Successfully processed: $successCount records\n";
        echo "Skipped/Errors: $skipCount records\n";
        echo "Total lines processed: " . (count($lines)) . "\n";
        
        if (!empty($errors)) {
            echo "\n=== Errors ===\n";
            foreach (array_slice($errors, 0, 10) as $error) { // Show first 10 errors
                echo "- $error\n";
            }
            if (count($errors) > 10) {
                echo "... and " . (count($errors) - 10) . " more errors\n";
            }
        }
        
        // Show final count
        $finalCount = FormOtherAstra::count();
        echo "\nFinal form_other_astras count: $finalCount\n";
    }
    
    /**
     * Parse date from various formats
     */
    private function parseDate($dateString)
    {
        try {
            $dateString = trim($dateString);
            
            // Handle format like "Jun 1, 2025"
            if (preg_match('/^([A-Za-z]{3})\s+(\d{1,2}),\s+(\d{4})$/', $dateString, $matches)) {
                $month = $matches[1];
                $day = $matches[2];
                $year = $matches[3];
                
                $date = Carbon::createFromFormat('M j, Y', "$month $day, $year");
                return $date->format('Y-m-d');
            }
            
            // Try other common formats
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y'];
            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $dateString);
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            // Default fallback
            return '2025-01-01';
            
        } catch (\Exception $e) {
            return '2025-01-01';
        }
    }
    
    /**
     * Parse rating from text to numeric value
     */
    private function parseRating($ratingText)
    {
        $ratingText = trim($ratingText);
        
        if (empty($ratingText) || strtoupper($ratingText) === 'N/A') {
            return null;
        }
        
        // Extract number from patterns like "Level Basic (1)", "Level Intermediate (2)", etc.
        if (preg_match('/\((\d+)\)/', $ratingText, $matches)) {
            $rating = (int)$matches[1];
            // Validate range (1-4)
            if ($rating >= 1 && $rating <= 4) {
                return $rating;
            }
        }
        
        // Fallback for direct numbers
        if (is_numeric($ratingText)) {
            $rating = (int)$ratingText;
            if ($rating >= 1 && $rating <= 4) {
                return $rating;
            }
        }
        
        return null;
    }
}
