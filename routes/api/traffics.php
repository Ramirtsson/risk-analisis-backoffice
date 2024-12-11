<?php

use App\Http\Controllers\TraficcController;
use Illuminate\Support\Facades\Route;

Route::get('/traffics/active-records',[TraficcController::class, 'activeRecords']);
Route::patch('/traficcs/{id}/status/{status}', [TraficcController::class, 'changeStatus']);
Route::apiResource('traficcs', TraficcController::class)->only('index','store','update');
