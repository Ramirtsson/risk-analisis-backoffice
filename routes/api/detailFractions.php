<?php

use App\Http\Controllers\DetailFractionController;
use Illuminate\Support\Facades\Route;

Route::get('/detail-fractions/active-records',[DetailFractionController::class, 'activeRecords']);
Route::get('/detail-fractions/{id}',[DetailFractionController::class, 'show']);
Route::post('/detail-fractions/import', [DetailFractionController::class, 'importDetailFractions']);
Route::patch('/detail-fractions/{id}/status/{status}', [DetailFractionController::class, 'changeStatus']);
Route::apiResource('/detail-fractions', DetailFractionController::class)->only('index','store','update');