<?php

use App\Http\Controllers\ManifestFileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/manifest-files', ManifestFileController::class)->only('store','destroy');
Route::get('/manifest-files/{manifest_file}/download', [ManifestFileController::class,"download"]);