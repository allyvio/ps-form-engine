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
});

Route::get('/download-report',[AssesmentController::class, 'downloadReport']);
