<?php

use App\Http\Controllers\AssesmentController;
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

Route::get('/', function () {
    $breadcrumb1 = 'Dashboard';
    $breadcrumb2 = null;
    $button = false;
    return view('dashboard.index', compact('breadcrumb1', 'breadcrumb2', 'button'));
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
