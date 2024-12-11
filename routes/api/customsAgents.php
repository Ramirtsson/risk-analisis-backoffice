<?php

use App\Http\Controllers\CustomsAgentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/customs-agent', CustomsAgentController::class)->only('index','store','update');
Route::get('/customs-agent/active-records',[CustomsAgentController::class, 'activeRecords']);
Route::patch('/customs-agent/{id}/status/{status}', [CustomsAgentController::class, 'changeStatus']);
Route::post('/customs-agent/{id}/custom-houses', [CustomsAgentController::class, 'customAgentcustomHouse']);
Route::get('/customs-agent/{id}/custom-houses', [CustomsAgentController::class, 'customsHouse']);