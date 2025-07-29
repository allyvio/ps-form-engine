<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GapAnalysisService;

class GenerateGapAnalysis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gap:generate {--reviewee-id= : Generate gap analysis for specific reviewee ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate gap analysis by comparing actual assessment ratings with expected competency matrix levels';

    /**
     * The gap analysis service instance.
     *
     * @var GapAnalysisService
     */
    protected $gapAnalysisService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GapAnalysisService $gapAnalysisService)
    {
        parent::__construct();
        $this->gapAnalysisService = $gapAnalysisService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Starting Gap Analysis Generation...');
        
        $revieweeId = $this->option('reviewee-id');
        
        try {
            if ($revieweeId) {
                // Generate for specific reviewee
                $this->info("Generating gap analysis for reviewee ID: $revieweeId");
                
                $result = $this->gapAnalysisService->generateGapAnalysisForReviewee($revieweeId);
                
                if ($result) {
                    $this->info("✅ Gap analysis generated successfully for: {$result->reviewee_name}");
                    $this->displayGapSummary($result);
                } else {
                    $this->warn("⚠️  No assessments found for reviewee ID: $revieweeId");
                }
                
            } else {
                // Generate for all reviewees with progress bar
                $revieweeIds = \App\Models\FormOtherAstra::distinct('reviewee_id')
                                        ->whereNotNull('reviewee_id') 
                                        ->pluck('reviewee_id');
                
                $this->info("Generating gap analysis for {$revieweeIds->count()} reviewees...");
                
                $progressBar = $this->output->createProgressBar($revieweeIds->count());
                $progressBar->start();
                
                $successCount = 0;
                $errorCount = 0;
                
                foreach ($revieweeIds as $revieweeId) {
                    try {
                        $this->gapAnalysisService->generateGapAnalysisForReviewee($revieweeId);
                        $successCount++;
                    } catch (\Exception $e) {
                        $this->error("Failed for reviewee $revieweeId: " . $e->getMessage());
                        $errorCount++;
                    }
                    $progressBar->advance();
                }
                
                $progressBar->finish();
                $this->newLine();
                
                $this->info("✅ Gap Analysis Generation Completed!");
                $this->info("📊 Results Summary:");
                $this->info("   • Successfully processed: $successCount reviewees");
                $this->info("   • Errors encountered: $errorCount reviewees");
                $this->info("   • Total processed: " . ($successCount + $errorCount) . " reviewees");
                
                if ($errorCount > 0) {
                    $this->warn("⚠️  Some errors occurred. Check the output above for details.");
                }
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error generating gap analysis: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Display gap summary for a single reviewee
     */
    private function displayGapSummary($gapAnalysis)
    {
        $this->info("📈 Gap Analysis Summary:");
        $this->info("   • Department: {$gapAnalysis->departemen}");
        $this->info("   • Function: {$gapAnalysis->fungsi}");
        $this->info("   • Overall Gap Score: {$gapAnalysis->overall_gap_score}");
        $this->info("   • Gaps Below Expectation: {$gapAnalysis->total_gaps_below}");
        $this->info("   • Gaps Above Expectation: {$gapAnalysis->total_gaps_above}");
        $this->info("   • Gaps Meeting Expectation: {$gapAnalysis->total_gaps_equal}");
        
        // Show top 3 competencies that need improvement
        $competencies = [
            'Risk Management' => $gapAnalysis->risk_management_gap,
            'Business Continuity' => $gapAnalysis->business_continuity_gap,
            'Personnel Management' => $gapAnalysis->personnel_management_gap,
            'Physical Security' => $gapAnalysis->physical_security_gap,
            'Cyber Security' => $gapAnalysis->cyber_security_gap,
        ];
        
        $topGaps = collect($competencies)
            ->filter(function($gap) { return $gap !== null && $gap > 0; })
            ->sortDesc()
            ->take(3);
        
        if ($topGaps->isNotEmpty()) {
            $this->info("🎯 Top Areas for Improvement:");
            foreach ($topGaps as $competency => $gap) {
                $this->info("   • $competency: gap of $gap points");
            }
        }
    }
}
