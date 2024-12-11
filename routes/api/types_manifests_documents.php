<?php

use \App\Http\Controllers\TypeManifestDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/types-manifests-documents/active-records',[TypeManifestDocumentController::class, 'activeRecords']);
Route::patch('/types-manifests-documents/{id}/status/{status}', [TypeManifestDocumentController::class, 'changeStatus']);
Route::get('/types-manifests-documents/{types_manifests_document}/manifest-file', [TypeManifestDocumentController::class, 'show']);
Route::apiResource('/types-manifests-documents', TypeManifestDocumentController::class)->only('index','store','update');
