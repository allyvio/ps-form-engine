<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompetencyMatrix;

class CompetencyMatrixSeeder extends Seeder
{
    public function run()
    {
        $csvFile = storage_path('app/competencies/matrix.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("Matrix CSV file not found: $csvFile");
            return;
        }
        
        $this->command->info("Reading competency matrix from CSV...");
        
        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle, 0, ';'); // Skip header row 1
        $competencyHeader = fgetcsv($handle, 0, ';'); // Get competency names from row 2
        
        $count = 0;
        $currentDepartemen = '';
        
        while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
            // Skip empty rows
            if (empty($data[0]) && empty($data[1])) continue;
            
            // Update department if present
            if (!empty($data[0])) {
                $currentDepartemen = trim($data[0]);
            }
            
            // Skip if no function name
            if (empty($data[1])) continue;
            
            $fungsi = trim($data[1]);
            
            // Extract competency expected levels
            $matrixData = [
                'departemen' => $currentDepartemen,
                'fungsi' => $fungsi,
                'risk_management_expected' => $this->parseExpectedLevel($data[2] ?? ''),
                'business_continuity_expected' => $this->parseExpectedLevel($data[3] ?? ''),
                'personnel_management_expected' => $this->parseExpectedLevel($data[4] ?? ''),
                'global_tech_awareness_expected' => $this->parseExpectedLevel($data[5] ?? ''),
                'physical_security_expected' => $this->parseExpectedLevel($data[6] ?? ''),
                'practical_security_expected' => $this->parseExpectedLevel($data[7] ?? ''),
                'cyber_security_expected' => $this->parseExpectedLevel($data[8] ?? ''),
                'investigation_case_mgmt_expected' => $this->parseExpectedLevel($data[9] ?? ''),
                'business_intelligence_expected' => $this->parseExpectedLevel($data[10] ?? ''),
                'basic_intelligence_expected' => $this->parseExpectedLevel($data[11] ?? ''),
                'mass_conflict_mgmt_expected' => $this->parseExpectedLevel($data[12] ?? ''),
                'legal_compliance_expected' => $this->parseExpectedLevel($data[13] ?? ''),
                'disaster_management_expected' => $this->parseExpectedLevel($data[14] ?? ''),
                'sar_expected' => $this->parseExpectedLevel($data[15] ?? ''),
                'assessor_expected' => $this->parseExpectedLevel($data[16] ?? '')
            ];
            
            CompetencyMatrix::create($matrixData);
            $count++;
        }
        
        fclose($handle);
        
        $this->command->info("Successfully imported $count competency matrix records");
    }
    
    private function parseExpectedLevel($value)
    {
        $value = strtoupper(trim($value));
        
        // Return null for N/A values
        if ($value === 'N/A' || empty($value)) {
            return null;
        }
        
        // Convert numeric values
        if (is_numeric($value)) {
            $level = (int)$value;
            return ($level >= 1 && $level <= 4) ? $level : null;
        }
        
        return null;
    }
}
