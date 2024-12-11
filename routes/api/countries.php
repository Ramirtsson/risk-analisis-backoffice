<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/countries/active-records',[CountryController::class, 'activeRecords']);
Route::patch('/countries/{id}/status/{status}', [CountryController::class, 'changeStatus']);
Route::apiResource('/countries', CountryController::class)->only('index','store','update');