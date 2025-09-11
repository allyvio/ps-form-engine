<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncAssessmentCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assessment:sync-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync assessment counts in reviewer_assignments table with actual data from form_other_astras';

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
        $this->info('Starting assessment count synchronization...');
        
        // Get actual assessment counts
        $actualCounts = DB::table('form_other_astras')
            ->select('reviewer_id', 'reviewee_id', DB::raw('count(*) as assessment_count'))
            ->groupBy('reviewer_id', 'reviewee_id')
            ->get();
        
        $this->info('Found ' . $actualCounts->count() . ' reviewer-reviewee pairs with assessments');
        
        // Reset all counts to 0 first
        DB::table('reviewer_assignments')->update(['assessment_count' => 0]);
        
        // Update with actual counts
        $updated = 0;
        $bar = $this->output->createProgressBar($actualCounts->count());
        $bar->start();
        
        foreach ($actualCounts as $count) {
            $result = DB::table('reviewer_assignments')
                ->where('reviewer_id', $count->reviewer_id)
                ->where('reviewee_id', $count->reviewee_id)
                ->update(['assessment_count' => $count->assessment_count]);
            
            if ($result > 0) {
                $updated += $result;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        // Show results
        $this->info('Synchronization completed!');
        $this->info('Updated ' . $updated . ' assignment records');
        
        // Display statistics
        $stats = DB::table('reviewer_assignments')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN assessment_count > 0 THEN 1 ELSE 0 END) as completed,
                SUM(assessment_count) as total_assessments
            ')
            ->first();
        
        $completionRate = round(($stats->completed / $stats->total) * 100, 2);
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Assignments', $stats->total],
                ['Completed Assignments', $stats->completed],
                ['Pending Assignments', $stats->total - $stats->completed],
                ['Total Assessments', $stats->total_assessments],
                ['Completion Rate', $completionRate . '%']
            ]
        );
        
        // Show breakdown by role
        $this->newLine();
        $this->info('Breakdown by Role:');
        
        $byRole = DB::table('reviewer_assignments')
            ->select('reviewer_role', 
                    DB::raw('count(*) as total'),
                    DB::raw('sum(case when assessment_count > 0 then 1 else 0 end) as completed'))
            ->groupBy('reviewer_role')
            ->orderBy('reviewer_role')
            ->get();
        
        $roleData = [];
        foreach ($byRole as $role) {
            $roleCompletion = round(($role->completed / $role->total) * 100, 1);
            $roleData[] = [
                $role->reviewer_role,
                $role->completed . '/' . $role->total,
                $roleCompletion . '%'
            ];
        }
        
        $this->table(['Role', 'Completed/Total', 'Completion %'], $roleData);
        
        return Command::SUCCESS;
    }
}