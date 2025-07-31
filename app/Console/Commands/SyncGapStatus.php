<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peserta;
use App\Models\GapAnalysis;
use App\Services\RecommendationService;

class SyncGapStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gap:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync gap analysis status for all peserta with existing gap analysis data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting gap status sync...');
        
        // Get all gap analysis records
        $gapAnalyses = GapAnalysis::all();
        $recommendationService = new RecommendationService();
        
        $updated = 0;
        $total = $gapAnalyses->count();
        
        $this->info("Found {$total} gap analysis records to process.");
        
        foreach ($gapAnalyses as $gapAnalysis) {
            // Calculate recommendation
            $recommendation = $recommendationService->calculateRecommendation($gapAnalysis);
            $percentage = $recommendation['percentage'];
            $status = $this->getStatusFromPercentage($percentage);
            
            // Update peserta record
            $updated += Peserta::where('id', $gapAnalysis->reviewee_id)
                ->update([
                    'gap_status' => $status,
                    'gap_percentage' => $percentage
                ]);
                
            $this->line("Updated peserta ID {$gapAnalysis->reviewee_id}: {$status} ({$percentage}%)");
        }
        
        $this->info("✅ Sync completed! Updated {$updated} peserta records.");
        return 0;
    }
    
    /**
     * Get status text from percentage
     */
    private function getStatusFromPercentage($percentage)
    {
        if ($percentage == 100) {
            return 'Memenuhi Kriteria';
        } elseif ($percentage >= 75) {
            return 'Cukup Memenuhi';
        } elseif ($percentage >= 37.5) {
            return 'Kurang Memenuhi';
        } else {
            return 'Belum Memenuhi';
        }
    }
}
