<?php

use App\Http\Controllers\AssesmentController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
    $breadcrumb1 = 'Dashboard';
    $breadcrumb2 = null;
    $button = false;
    
    // Analytical data
    $totalPeserta = \App\Models\Peserta::count();
    $totalAssessments = \App\Models\FormOtherAstra::count();
    $totalReviewers = \App\Models\FormOtherAstra::distinct('reviewer_id')->count('reviewer_id');
    $totalDepartments = \App\Models\FormOtherAstra::distinct('departemen')->whereNotNull('departemen')->count('departemen');
    
    // Gap Analysis completion statistics
    $gapAnalysisCompleted = \App\Models\GapAnalysis::count();
    $gapAnalysisCompletionRate = $totalPeserta > 0 ? round(($gapAnalysisCompleted / $totalPeserta) * 100, 1) : 0;
    
    // Assessment completion by role
    $assessmentsByRole = \App\Models\FormOtherAstra::select('peran')
        ->selectRaw('count(*) as count')
        ->groupBy('peran')
        ->pluck('count', 'peran')
        ->toArray();
    
    // Recommendation statistics using RecommendationService
    $recommendationService = new \App\Services\RecommendationService();
    $gapAnalyses = \App\Models\GapAnalysis::all();
    $recommendationStats = [
        'memenuhi' => 0,
        'cukup_memenuhi' => 0,
        'kurang_memenuhi' => 0,
        'belum_memenuhi' => 0
    ];
    
    foreach ($gapAnalyses as $gapAnalysis) {
        $recommendation = $recommendationService->calculateRecommendation($gapAnalysis);
        $percentage = $recommendation['percentage'];
        
        if ($percentage == 100) {
            $recommendationStats['memenuhi']++;
        } elseif ($percentage >= 75) {
            $recommendationStats['cukup_memenuhi']++;
        } elseif ($percentage >= 37.5) {
            $recommendationStats['kurang_memenuhi']++;
        } else {
            $recommendationStats['belum_memenuhi']++;
        }
    }
    
    // Top performing competencies across all participants
    $competencies = [
        'risk_management' => 'Risk Management',
        'business_continuity' => 'Business Continuity',
        'personnel_management' => 'Personnel Management',
        'global_tech_awareness' => 'Global & Technological Awareness',
        'physical_security' => 'Physical Security',
        'practical_security' => 'Practical Security',
        'cyber_security' => 'Cyber Security',
        'investigation_case_mgmt' => 'Investigation & Case Management',
        'business_intelligence' => 'Business Intelligence',
        'basic_intelligence' => 'Basic Intelligence',
        'mass_conflict_mgmt' => 'Mass & Conflict Management',
        'legal_compliance' => 'Legal & Compliance',
        'disaster_management' => 'Disaster Management',
        'sar' => 'SAR',
        'assessor' => 'Assessor'
    ];
    
    $competencyPerformance = [];
    foreach ($competencies as $key => $name) {
        $avgActual = \App\Models\GapAnalysis::whereNotNull($key . '_actual')
            ->avg($key . '_actual');
        if ($avgActual !== null) {
            $competencyPerformance[$name] = round($avgActual, 2);
        }
    }
    
    // Sort by performance (highest first)
    arsort($competencyPerformance);
    
    // Average overall performance
    $overallPerformance = array_sum($competencyPerformance) / count($competencyPerformance);
    
    $analyticalData = compact(
        'totalPeserta', 'totalAssessments', 'totalReviewers', 'totalDepartments',
        'gapAnalysisCompleted', 'gapAnalysisCompletionRate', 'assessmentsByRole',
        'recommendationStats', 'competencyPerformance', 'overallPerformance'
    );
    
    return view('dashboard.index', compact('breadcrumb1', 'breadcrumb2', 'button', 'analyticalData'));
    });

    Route::group(['prefix' => 'astra'], function () {
        Route::get('/peserta', [AssesmentController::class, 'listPeserta']);
        Route::get('/peserta/{id}',[AssesmentController::class, 'detailPeserta']);
        Route::get('/reviewer-assignments', [AssesmentController::class, 'reviewerAssignments']);
        Route::get('/assessment-data', [AssesmentController::class, 'assessmentData']);
        Route::get('/assessment-data/{id}', [AssesmentController::class, 'assessmentDetail']);
    });

    Route::get('/download-report',[AssesmentController::class, 'downloadReport']);
    Route::get('/download-gap-report/{id}',[AssesmentController::class, 'downloadGapAnalysisReport']);

    Route::get('/query-participant', function () {
        $participant = \App\Models\Peserta::whereHas('reviewedAssessments')->first();
        
        if (!$participant) {
            $participant = \App\Models\Peserta::first();
        }
        
        $assessments = \App\Models\FormOtherAstra::where('reviewee_id', $participant->id ?? 0)->get();
        
        return response()->json([
            'participant' => $participant,
            'assessments_count' => $assessments->count(),
            'assessments' => $assessments->take(3) // First 3 assessments for sample
        ]);
    });
});
