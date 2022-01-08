<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['api'], function () {
    Route::get('/score', [ScoreController::class, 'index']);
    Route::post('/score', [ScoreController::class, 'index']);
    Route::get('/score/{id}', [ScoreController::class, 'get']);
    Route::post('/score/add', [ScoreController::class, 'create']);

    Route::get('/filters', [FilterController::class, 'index']);
});
