<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\AccessAPIDocumentationController;
use App\Http\Controllers\MakeUserController;

/**
 * public routes
 */
Route::post('/oauth/token', [
    'uses' => 'Laravel\Passport\Http\Controllers\AccessTokenController@issueToken',
    'as' => 'token',
    'middleware' => 'throttle',
]);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', AccessAPIDocumentationController::class);
});



/**
 * protected routes
 */

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', AuthUserController::class);
    Route::post('logout', [AuthController::class, 'logout']);


    Route::post('/make-user', MakeUserController::class);

    /**
     * Catalogos
     */
    require __DIR__.'/api/users.php';
    require __DIR__.'/api/modules.php';
    require __DIR__.'/api/traffics.php';
    require __DIR__.'/api/branches.php';
    require __DIR__.'/api/courier_companies.php';
    require __DIR__.'/api/warehouses.php';
    require __DIR__.'/api/WarehouseOffice.php';
    require __DIR__.'/api/customers.php';
    require __DIR__.'/api/client-types.php';
    require __DIR__.'/api/operating_statuses.php';
    require __DIR__.'/api/application_concepts.php';
    require __DIR__.'/api/customsAgents.php';
    require __DIR__.'/api/suppliers.php';
    require __DIR__.'/api/countries.php';
    require __DIR__.'/api/tconcepts.php';
    require __DIR__.'/api/unitMeasures.php';
    require __DIR__.'/api/fractions.php';
    require __DIR__.'/api/detailFractions.php';
    require __DIR__.'/api/levelProducts.php';
    require __DIR__.'/api/kasaSystemKeys.php';
    require __DIR__.'/api/exceptions.php';
    require __DIR__.'/api/exchange_rates.php';
    require __DIR__.'/api/consignees.php';
    require __DIR__.'/api/customHouses.php';
    require __DIR__.'/api/currencies.php';
    require __DIR__.'/api/manifests.php';
    require __DIR__.'/api/roles.php';
    require __DIR__.'/api/value_types.php';
    require __DIR__.'/api/payment_types.php';
    require __DIR__.'/api/types_manifests_documents.php';
    require __DIR__.'/api/permissions.php';
    require __DIR__.'/api/accounts_nexen.php';
    require __DIR__.'/api/manifest_files.php';
    require __DIR__.'/api/payment_request.php';
});
