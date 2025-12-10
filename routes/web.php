<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AHPController;
use App\Http\Controllers\AlternativeScoreController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubCriterionController;
use App\Http\Controllers\TOPSISController;

Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Alternatives Routes
    Route::resource('alternatives', AlternativeController::class)
        ->except(['show']);

    // Criteria Routes
    Route::resource('criteria', CriterionController::class)
        ->except(['show']);

    // Sub-Criteria Routes (nested under criteria)
    Route::resource('criteria.sub_criteria', SubCriterionController::class)
        ->shallow()
        ->except(['show']);

    // Alternative Scores Routes
    Route::get('alternatives/{alternative}/scores', [AlternativeScoreController::class, 'editByAlternative'])
        ->name('alternatives.scores.edit');
    Route::put('alternatives/{alternative}/scores', [AlternativeScoreController::class, 'updateByAlternative'])
        ->name('alternatives.scores.update');

    // AHP Routes
    Route::get('ahp', [AHPController::class, 'index'])
        ->name('ahp.index');
    Route::post('ahp/comparisons', [AHPController::class, 'storeComparisons'])
        ->name('ahp.storeComparisons');
    Route::post('ahp/calculate', [AHPController::class, 'calculate'])
        ->name('ahp.calculate');

    // TOPSIS Routes
    Route::get('topsis', [TOPSISController::class, 'index'])
        ->name('topsis.index');
    Route::post('topsis/calculate', [TOPSISController::class, 'calculate'])
        ->name('topsis.calculate');

});