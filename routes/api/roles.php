<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/roles', RoleController::class)->only('index','store','update');
Route::get('/roles/get-roles', [RoleController::class,'getRoles']);