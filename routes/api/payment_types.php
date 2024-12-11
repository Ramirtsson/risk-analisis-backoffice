<?php

use App\Http\Controllers\PaymentTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/payment-types', PaymentTypeController::class);