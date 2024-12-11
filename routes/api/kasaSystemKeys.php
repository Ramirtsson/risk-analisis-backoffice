<?php

use App\Http\Controllers\KasaSystemKeyController;
use Illuminate\Support\Facades\Route;

Route::get('/kasa-system-keys/active-records',[KasaSystemKeyController::class, 'activeRecords']);
Route::apiResource('/kasa-system-keys',KasaSystemKeyController::class)->only('index','store','update');
Route::patch('/kasa-system-keys/{id}/status/{status}',[KasaSystemKeyController::class, 'changeStatus']);