<?php

use App\Http\Controllers\ManifestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadManifestController;

Route::apiResource('/manifests', ManifestController::class)->only('index','store','update');
Route::patch('/manifests/{id}/status/{status}', [ManifestController::class, 'changeStatus']);
Route::get('/manifests/{id}', [ManifestController::class, 'show']);
Route::patch('/manifests/{id}/operating-status/{status}',[ManifestController::class, 'changeOperatingStatus']);
Route::post('/manifests/upload', UploadManifestController::class);
