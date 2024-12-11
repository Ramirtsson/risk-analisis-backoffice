<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get('/exchange-rates/active-records', [ExchangeRateController::class, 'activeRecords']);
Route::patch('/exchange-rates/{id}/status/{status}', [ExchangeRateController::class, 'changeStatus']);
Route::apiResource('/exchange-rates', ExchangeRateController::class)->only('index','store','update');
Route::get('/exchange-rates/{date}/date', [ExchangeRateController::class, 'fetchByDate']);