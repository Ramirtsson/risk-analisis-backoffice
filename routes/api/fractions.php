<?php

use App\Http\Controllers\FractionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/fractions', FractionController::class)->only('index','store','update');
Route::patch('/fractions/{id}/status/{status}', [FractionController::class, 'changeStatus']);
Route::post('/fractions/import', [FractionController::class, 'importFractions']);
Route::get('/fractions/active-records',[FractionController::class, 'activeRecords']);
