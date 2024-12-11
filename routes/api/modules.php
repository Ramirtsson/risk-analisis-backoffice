<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemModuleController;

Route::get('/modules/active-records', [SystemModuleController::class, 'activeRecords']);
Route::patch('/modules/{id}/status/{status}', [SystemModuleController::class, 'changeStatus']);
Route::apiResource('modules', SystemModuleController::class);
