<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompetencyMatrix;
use Illuminate\Support\Facades\DB;

class NewCompetencyMatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Importing new competency matrix data from CSV...\n";
        
        $filePath = storage_path('app/competencies/new_matrix.csv');
        
        if (!file_exists($filePath)) {
            echo "Error: new_matrix.csv not found at $filePath\n";
            return;
        }
        
        // Clear existing data
        CompetencyMatrix::truncate();
        echo "Cleared existing competency matrix data\n";
        
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Skip header row
        array_shift($lines);
        
        $successCount = 0;
        $skipCount = 0;
        $errors = [];
        
        foreach ($lines as $lineNum => $line) {
            $lineNum += 2; // Adjust for header and 0-based index
            
            // Skip empty lines
            if (empty(trim($line))) {
                echo "Skipping empty line $lineNum\n";
                $skipCount++;
                continue;
            }
            
            $data = str_getcsv($line, ';');
            
            // Skip if not enough columns or all department/function fields are empty
            if (count($data) < 17 || empty(trim($data[0])) || empty(trim($data[2]))) {
                echo "Skipping incomplete line $lineNum\n";
                $skipCount++;
                continue;
            }
            
            try {
                // Map CSV columns to database fields
                $matrixData = [
                    'departemen' => trim($data[0]),
                    'fungsi' => trim($data[2]), // Use Function column (index 2), not Jabatan
                    'risk_management_expected' => $this->parseValue($data[3]),
                    'business_continuity_expected' => $this->parseValue($data[4]),
                    'personnel_management_expected' => $this->parseValue($data[5]),
                    'global_tech_awareness_expected' => $this->parseValue($data[6]),
                    'physical_security_expected' => $this->parseValue($data[7]),
                    'practical_security_expected' => $this->parseValue($data[8]),
                    'cyber_security_expected' => $this->parseValue($data[9]),
                    'investigation_case_mgmt_expected' => $this->parseValue($data[10]),
                    'business_intelligence_expected' => $this->parseValue($data[11]),
                    'basic_intelligence_expected' => $this->parseValue($data[12]),
                    'mass_conflict_mgmt_expected' => $this->parseValue($data[13]),
                    'legal_compliance_expected' => $this->parseValue($data[14]),
                    'disaster_management_expected' => $this->parseValue($data[15]),
                    'sar_expected' => $this->parseValue($data[16]),
                    'assessor_expected' => isset($data[17]) ? $this->parseValue($data[17]) : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                // Check for duplicates
                $existing = CompetencyMatrix::where('departemen', $matrixData['departemen'])
                                          ->where('fungsi', $matrixData['fungsi'])
                                          ->first();
                
                if ($existing) {
                    echo "⚠️  Duplicate found for {$matrixData['departemen']} - {$matrixData['fungsi']}, updating...\n";
                    $existing->update($matrixData);
                } else {
                    CompetencyMatrix::create($matrixData);
                    echo "✓ Created: {$matrixData['departemen']} - {$matrixData['fungsi']}\n";
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
            foreach ($errors as $error) {
                echo "- $error\n";
            }
        }
        
        // Show final count
        $finalCount = CompetencyMatrix::count();
        echo "\nFinal competency matrix count: $finalCount\n";
    }
    
    /**
     * Parse competency value, converting N/A to null and validating numeric values
     */
    private function parseValue($value)
    {
        $value = trim($value);
        
        if (empty($value) || strtoupper($value) === 'N/A') {
            return null;
        }
        
        if (is_numeric($value)) {
            $numValue = (int)$value;
            // Validate range (1-4 based on observed data)
            if ($numValue >= 1 && $numValue <= 4) {
                return $numValue;
            }
        }
        
        // Return null for invalid values
        return null;
    }
}
