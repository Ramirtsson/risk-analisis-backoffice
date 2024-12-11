<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValueTypeController;

Route::get('/value-types', ValueTypeController::class);