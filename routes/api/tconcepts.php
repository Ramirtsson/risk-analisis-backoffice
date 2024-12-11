<?php

use App\Http\Controllers\TConceptController;
use Illuminate\Support\Facades\Route;

Route::get('/tconcepts/active-records',[TConceptController::class, 'activeRecords']);
Route::patch('/tconcepts/{id}/status/{status}', [TConceptController::class, 'changeStatus']);
Route::apiResource('/tconcepts', TConceptController::class)->only('index','store','update');