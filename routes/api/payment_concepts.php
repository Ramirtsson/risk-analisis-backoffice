<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentConceptController;

Route::get('/payment-concepts/active-records', [PaymentConceptController::class,'activeRecords']);
Route::patch('/payment-concepts/{id}/status/{status}', [PaymentConceptController::class, 'changeStatus']);
Route::apiResource('/payment-concepts', PaymentConceptController::class);