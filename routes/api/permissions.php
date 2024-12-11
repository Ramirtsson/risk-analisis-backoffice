<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/permissions', PermissionController::class)->only('index','store','update');
Route::get('/permissions/get-permissions', [PermissionController::class,'getPermissions']);