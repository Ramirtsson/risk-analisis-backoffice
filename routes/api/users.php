<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/active-records',[UserController::class, 'activeRecords']);
Route::put('/users/{user}/password',[UserController::class,'updatePassword']);
Route::patch('/users/{id}/status/{status}', [UserController::class, 'changeStatus']);
Route::apiResource('/users', UserController::class)->only('index','store','update');
Route::post('/users/verifySupervisor',[UserController::class,'verifySupervisor']);
// Route::apiResource(name: 'user-data', UserController::class);