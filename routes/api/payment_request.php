<?php

use App\Http\Controllers\PaymentRequestController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/payment_request', PaymentRequestController::class)->only('index','store','update');