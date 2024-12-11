<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

Route::get('/branches/active-records', [BranchController::class,'activeRecords']);
Route::patch('/branches/{id}/status/{status}', [BranchController::class, 'changeStatus']);
Route::apiResource('/branches', BranchController::class);
