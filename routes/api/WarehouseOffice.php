<?php
use App\Http\Controllers\WarehouseOfficeController;
use Illuminate\Support\Facades\Route;


Route::apiResource('/warehouseOffice', WarehouseOfficeController::class)->only('index','store','update');
Route::patch('/warehouseOffice/{id}/status/{status}', [WarehouseOfficeController::class, 'changeStatus']);
Route::get('/warehouseOffice/active-records',[WarehouseOfficeController::class, 'activeRecords']);

