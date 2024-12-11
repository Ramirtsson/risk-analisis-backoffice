<?php

use App\Http\Controllers\UnitMeasuresController;
use Illuminate\Support\Facades\Route;

Route::get('/unit-measures/active-records',[UnitMeasuresController::class, 'activeRecords']);
Route::apiResource('/unit-measures',UnitMeasuresController::class)->only('index','store','update');
Route::patch('/unit-measures/{id}/status/{status}',[UnitMeasuresController::class, 'changeStatus']);