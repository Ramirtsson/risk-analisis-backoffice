<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::get('/currencies/active-records', [CurrencyController::class,'activeRecords']);