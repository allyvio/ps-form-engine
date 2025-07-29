<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Peserta;

class ReviewerAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        DB::table('reviewer_assignments')->truncate();
        
        // Path ke CSV file
        $csvPath = storage_path('app/peserta/resource_01.csv');
        
        if (!file_exists($csvPath)) {
            $this->command->error('CSV file not found: ' . $csvPath);
            return;
        }
        
        // Baca CSV file
        $csvData = array_map('str_getcsv', file($csvPath));
        
        // Remove header rows (first 4 rows)
        $csvData = array_slice($csvData, 4);
        
        // Get all peserta for ID mapping
        $pesertaMap = Peserta::all()->keyBy('name')->toArray();
        
        $reviewerRoles = [
            6 => 'Atasan Langsung',
            7 => 'Diri Sendiri',
            8 => 'Rekan Kerja 1', 
            9 => 'Rekan Kerja 2',
            10 => 'Bawahan Langsung 1',
            11 => 'Bawahan Langsung 2'
        ];
        
        $assessmentCounts = [
            12 => 'Atasan Langsung',
            13 => 'Diri Sendiri',
            14 => 'Rekan Kerja 1',
            15 => 'Rekan Kerja 2', 
            16 => 'Bawahan Langsung 1',
            17 => 'Bawahan Langsung 2'
        ];
        
        $assignments = [];
        
        foreach ($csvData as $row) {
            // Skip empty rows
            if (empty($row[0]) || !is_numeric($row[0])) {
                continue;
            }
            
            $revieweeId = (int) $row[0];
            $revieweeName = $row[1];
            
            // Process each reviewer role
            foreach ($reviewerRoles as $colIndex => $role) {
                $reviewerName = trim($row[$colIndex]);
                
                if (empty($reviewerName)) {
                    continue;
                }
                
                // Find reviewer ID from peserta table
                $reviewerId = null;
                if (isset($pesertaMap[$reviewerName])) {
                    $reviewerId = $pesertaMap[$reviewerName]['id'];
                }
                
                // Get assessment count
                $countIndex = $colIndex + 6; // Assessment counts start from column 12 (index 6 + 6)
                $assessmentCount = isset($row[$countIndex]) ? (int) $row[$countIndex] : 0;
                
                $assignments[] = [
                    'reviewee_id' => $revieweeId,
                    'reviewee_name' => $revieweeName,
                    'reviewer_id' => $reviewerId,
                    'reviewer_name' => $reviewerName,
                    'reviewer_role' => $role,
                    'assessment_count' => $assessmentCount,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        // Insert data in chunks for better performance
        $chunks = array_chunk($assignments, 100);
        foreach ($chunks as $chunk) {
            DB::table('reviewer_assignments')->insert($chunk);
        }
        
        $this->command->info('Successfully seeded ' . count($assignments) . ' reviewer assignments');
    }
}
