<?php

use App\Http\Controllers\LevelProductController;
use Illuminate\Support\Facades\Route;


Route::get('/level-products/active-records',[LevelProductController::class, 'activeRecords']);
