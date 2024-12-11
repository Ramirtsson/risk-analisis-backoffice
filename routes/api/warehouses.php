<?php

use App\Http\Controllers\WarehousesOriginController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/warehouses', WarehousesOriginController::class)->only('index','store','update');
Route::patch('/warehouses/{id}/status/{status}', [WarehousesOriginController::class, 'changeStatus']);
Route::get('/warehouses/active-records',[WarehousesOriginController::class, 'activeRecords']);
