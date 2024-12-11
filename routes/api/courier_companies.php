<?php

use App\Http\Controllers\CourierCompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/courier-companies/active-records',[CourierCompanyController::class, 'activeRecords']);
Route::patch('/courier-companies/{id}/status/{status}', [CourierCompanyController::class, 'changeStatus']);
Route::apiResource('/courier-companies', CourierCompanyController::class)->only('index','store','update');