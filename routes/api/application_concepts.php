<?php

use App\Http\Controllers\ApplicationConceptController;
use Illuminate\Support\Facades\Route;

Route::get('/application-concepts/active-records',[ApplicationConceptController::class, 'activeRecords']);
Route::apiResource('/application-concepts', ApplicationConceptController::class);
Route::patch('/application-concepts/{id}/status/{status}', [ApplicationConceptController::class, 'changeStatus']);