<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConvertExcelToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:convert {input} {output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Excel assessment file to clean CSV format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inputFile = $this->argument('input');
        $outputFile = $this->argument('output');
        
        $inputPath = storage_path('app/file_assessment/' . $inputFile);
        $outputPath = storage_path('app/file_assessment/' . $outputFile);
        
        if (!file_exists($inputPath)) {
            $this->error("Input file not found: $inputPath");
            return 1;
        }
        
        $this->info("Converting $inputFile to CSV format...");
        
        try {
            // Load Excel file
            $spreadsheet = IOFactory::load($inputPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            
            // Extract and process assessment data
            $csvData = [];
            $headers = [
                'submission_date',
                'reviewee_name', 
                'reviewer_name',
                'reviewer_role',
                'competency_1_rating',
                'competency_1_explanation',
                'competency_2_rating', 
                'competency_2_explanation',
                'competency_3_rating',
                'competency_3_explanation',
                'competency_4_rating',
                'competency_4_explanation',
                'competency_5_rating',
                'competency_5_explanation',
                'competency_6_rating',
                'competency_6_explanation',
                'competency_7_rating',
                'competency_7_explanation',
                'competency_8_rating',
                'competency_8_explanation',
                'competency_9_rating',
                'competency_9_explanation',
                'competency_10_rating',
                'competency_10_explanation',
                'competency_11_rating',
                'competency_11_explanation',
                'competency_12_rating',
                'competency_12_explanation',
                'competency_13_rating',
                'competency_13_explanation'
            ];
            
            $csvData[] = $headers;
            
            // Process each row (skip header row)
            for ($row = 2; $row <= count($data); $row++) {
                $rowData = $data[$row - 1];
                
                if (empty($rowData[1])) { // Skip if no reviewee name
                    continue;
                }
                
                // Extract basic info
                $submissionDate = $rowData[0] ?? '';
                $reviewerName = $rowData[1] ?? ''; // Column B is actually the reviewer (person doing the rating)
                $reviewerRole = $rowData[100] ?? ''; // Column CY - Peran Saudara
                
                // Find reviewee (person being rated) from columns C-CK (indexes 2-88)
                $revieweeName = 'Unknown';
                for ($col = 2; $col <= 88; $col++) {
                    if (!empty($rowData[$col]) && trim($rowData[$col]) !== '') {
                        $revieweeName = trim($rowData[$col]);
                        break;
                    }
                }
                
                // If no reviewee found in data columns, try alternative approach
                if ($revieweeName === 'Unknown') {
                    $revieweeName = 'System Generated';
                }
                
                // Extract competency ratings and explanations (13 competencies)
                $competencyData = [];
                $startCol = 101; // Column CZ (index 101)
                
                for ($comp = 1; $comp <= 13; $comp++) {
                    $ratingCol = $startCol + (($comp - 1) * 2);
                    $explanationCol = $startCol + (($comp - 1) * 2) + 1;
                    
                    $rating = $rowData[$ratingCol] ?? '';
                    $explanation = $rowData[$explanationCol] ?? '';
                    
                    // Convert rating text to numeric
                    $numericRating = $this->convertRatingToNumeric($rating);
                    
                    $competencyData[] = $numericRating;
                    $competencyData[] = $explanation;
                }
                
                // Build CSV row
                $csvRow = [
                    $submissionDate,
                    $revieweeName,
                    $reviewerName,
                    $reviewerRole
                ];
                
                $csvRow = array_merge($csvRow, $competencyData);
                $csvData[] = $csvRow;
            }
            
            // Write to CSV
            $fp = fopen($outputPath, 'w');
            foreach ($csvData as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
            
            $recordCount = count($csvData) - 1; // Exclude header
            $this->info("Successfully converted $recordCount assessment records to $outputFile");
            $this->info("Output saved to: $outputPath");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error("Error converting file: " . $e->getMessage());
            return 1;
        }
    }
    
    private function convertRatingToNumeric($ratingText)
    {
        $ratingText = strtolower(trim($ratingText));
        
        if (strpos($ratingText, 'basic') !== false) return 1;
        if (strpos($ratingText, 'intermediate') !== false) return 2;
        if (strpos($ratingText, 'middle') !== false) return 3;
        if (strpos($ratingText, 'executive') !== false) return 4;
        
        return 0; // Unknown or empty
    }
}
