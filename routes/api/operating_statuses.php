<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperatingStatusController;

Route::get('/operating-status/active-records', [OperatingStatusController::class,'activeRecords']);
Route::patch('/operating-status/{id}/status/{status}', [OperatingStatusController::class, 'changeStatus']);
Route::apiResource('/operating-status', OperatingStatusController::class)->only(['index', 'store', 'update']);
