<?php

use App\Http\Controllers\ExceptionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/exceptions', ExceptionController::class)->only('index','store','update');
Route::patch('/exceptions/{id}/status/{status}', [ExceptionController::class, 'changeStatus']);
Route::get('/exceptions/active-records',[ExceptionController::class, 'activeRecords']);
Route::get('/exceptions/{id}',[ExceptionController::class, 'show']);
