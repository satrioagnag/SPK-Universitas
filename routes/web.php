<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AHPController;
use App\Http\Controllers\AlternativeScoreController;
use App\Http\Controllers\AlternativeController;
use App\http\Controllers\CriterionController;
use App\http\Controllers\DashboardController;
use App\http\Controllers\SubCriterionController;
use App\http\Controllers\topsisController;
use App\http\Controllers\user;
use App\services\AHPService;
use App\services\TopsisService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

Route::group([], function () {

    route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    route::resource('alternatives', AlternativeController::class)
        ->except(['show']);

    route::resource('criteria', CriterionController::class)
        ->except(['show']);

    route::resource('criteria.sub_criteria', SubCriterionController::class)
        ->shallow()
        ->except(['show']);

    route::get('alternatives/{alternative}/edit', [AlternativeScoreController::class, 'editbyAlternative'])
        ->name('alternatives.scores.editbyAlternative');
    route::put('alternatives/{alternative}/edit', [AlternativeScoreController::class, 'updatebyAlternative'])
        ->name('alternatives.scores.updatebyAlternative');

    route::get('ahp', [AHPController::class, 'index'])
        ->name('ahp.index');
    route::post('ahp/comparisons', [AHPController::class, 'storeComparisons'])
        ->name('ahp.storeComparisons');
    route::post('ahp/calculate', [AHPController::class, 'calculate'])
        ->name('ahp.calculate');

    route::get('topsis', [TopsisController::class, 'index'])
        ->name('topsis.index');
    route::post('topsis/calculate', [TopsisController::class, 'calculate'])
        ->name('topsis.calculate');

});


