<?php

use App\Http\Controllers\CustomHouseController;
use Illuminate\Support\Facades\Route;

Route::get('/customs-house/active-records',[CustomHouseController::class, 'activeRecords']);
Route::apiResource('customs-house', CustomHouseController::class)->only('index','store','update');
Route::patch('/customs-house/{id}/status/{status}', [CustomHouseController::class, 'changeStatus']);
Route::get('/custom-houses/{id}',[CustomHouseController::class, 'show']);
