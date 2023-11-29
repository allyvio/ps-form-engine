<?php

use App\Http\Controllers\AssesmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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


Route::get('/admin', function () {
    $breadcrumb1 = 'Dashboard';
    $breadcrumb2 = null;
    $button = false;
    return view('dashboard.index', compact('breadcrumb1', 'breadcrumb2', 'button'));

});

Route::get('/people-form', function () {
  return view('test.index');

});

Route::group([
    'prefix' => '/assesment',
    'as' => 'Quiz',
  ], function () {
    Route::get('/create', [DashboardController::class, 'quisLayout']);
    Route::get('/detail/{id}', [DashboardController::class, 'editQuisLayout']);
    Route::get('/detail/{id}/package', [DashboardController::class, 'editPackageLayout']);
    Route::post('/create/project', [AssesmentController::class, 'projectLCreate']);
    Route::post('/create/package', [AssesmentController::class, 'packageCreate']);

    Route::post('/create/soal', [AssesmentController::class, 'soalCreate']);
  });

  Route::get('/', [AssesmentController::class, 'c']);

