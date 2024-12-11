<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsigneeController;

Route::get('/consignees/active-records',[ConsigneeController::class, 'activeRecords']);
Route::apiResource('consignees', ConsigneeController::class)->only('index','store','update');
Route::patch('/consignees/{id}/status/{status}', [ConsigneeController::class, 'changeStatus']);
