<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\ExportController;
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
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('expenses', ExpenseController::class)->except(['create', 'edit']);
    Route::get('statistics/yearly',  [StatisticController::class, 'yearly']);
    Route::get('statistics/monthly', [StatisticController::class, 'monthly']);
    Route::post('export-expenses',   [ExportController::class, 'export']);
});

Route::group(['middleware' => ['auth:api', 'can:admin']], function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});