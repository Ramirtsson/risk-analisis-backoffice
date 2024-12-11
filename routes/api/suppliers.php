<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/suppliers/active-records',[SupplierController::class, 'activeRecords']);
Route::patch('/suppliers/{id}/status/{status}', [SupplierController::class, 'changeStatus']);
Route::apiResource('/suppliers', SupplierController::class)->only('index','store','update');