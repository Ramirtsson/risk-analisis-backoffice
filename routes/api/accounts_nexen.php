<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountNexenController;

Route::get('/manifests/accounts/active-records', [AccountNexenController::class,'activeRecords']);
Route::get('/manifests/accounts/{id}', [AccountNexenController::class, 'accountsById']);