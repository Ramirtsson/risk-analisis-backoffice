<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientTypeController;

Route::get('/client-types/active-records', [ClientTypeController::class, 'activeRecords']);
