<?php

use App\Http\Controllers\CustomersController;
use Illuminate\Support\Facades\Route;

Route::get('/customers/active-records',[CustomersController::class, 'activeRecords']);
Route::apiResource('customers', CustomersController::class)->only('index','store','update','destroy');
Route::patch('/customers/{id}/status/{status}', [CustomersController::class, 'changeStatus']);