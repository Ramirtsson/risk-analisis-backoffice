<?php

namespace App\Providers;

use App\Http\Controllers\ApplicationConceptController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourierCompanyController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\CustomHouseController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\OperatingStatusController;
use App\Http\Controllers\CustomsAgentController;
use App\Http\Controllers\FractionController;
use App\Http\Controllers\DetailFractionController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\KasaSystemKeyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SystemModuleController;
use App\Http\Controllers\TConceptController;
use App\Http\Controllers\TraficcController;
use App\Http\Controllers\TypeManifestDocumentController;
use App\Http\Controllers\UnitMeasuresController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseOfficeController;
use App\Http\Controllers\WarehousesOriginController;
use App\Http\Controllers\RoleController;
use App\Models\TypeManifestDocument;
use App\Repositories\ApplicationConceptRepository;
use App\Repositories\BranchesRepository as BranchRepository;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Repositories\CountriesRepository;
use App\Repositories\CourierCompanyRepository;
use App\Repositories\CustomAgentRepository;
use App\Repositories\CustomersRepository;
use App\Repositories\CustomHousesRepository;
use App\Repositories\DetailFractionsRepository;
use App\Repositories\ExceptionsRepository;
use App\Repositories\FractionsRepository;
use App\Repositories\KasaSystemKeysRepository;
use App\Repositories\ManifestRepository;
use App\Repositories\ModulesRepository;
use App\Repositories\OperatingStatusRepository;
use App\Repositories\ConsigneesRepository;
use App\Repositories\SuppliersRepository;
use App\Repositories\TConceptsRepository;
use App\Repositories\TraficcsRepository;
use App\Repositories\UnitMeasuresRepository;
use App\Repositories\UserRepository;
use App\Repositories\WarehouseOfficesRepository;
use App\Repositories\ExchangeRatesRepository;
use App\Repositories\PermissionsRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Repositories\WarehousesOriginRepository;
use App\Repositories\RolesRepository;
Use App\Repositories\TypesManifestsDocumentsRepository;
use App\Services\Contracts\ImportFileContract;
use App\Services\Imports\ImportDetailFraction;
use App\Services\Imports\ImportFraction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
        Passport::enablePasswordGrant();

        $controllerBindings = [
            BranchController::class => BranchRepository::class,
            SystemModuleController::class => ModulesRepository::class,
            TraficcController::class => TraficcsRepository::class,
            UserController::class => UserRepository::class,
            CourierCompanyController::class => CourierCompanyRepository::class,
            WarehousesOriginController::class => WarehousesOriginRepository::class,
            WarehouseOfficeController::class => WarehouseOfficesRepository::class,
            CustomersController::class => CustomersRepository::class,
            OperatingStatusController::class => OperatingStatusRepository::class,
            ApplicationConceptController::class => ApplicationConceptRepository::class,
            CustomsAgentController::class => CustomAgentRepository::class,
            SupplierController::class => SuppliersRepository::class,
            CountryController::class => CountriesRepository::class,
            TConceptController::class => TConceptsRepository::class,
            UnitMeasuresController::class => UnitMeasuresRepository::class,
            FractionController::class => FractionsRepository::class,
            DetailFractionController::class => DetailFractionsRepository::class,
            KasaSystemKeyController::class => KasaSystemKeysRepository::class,
            ExceptionController::class=> ExceptionsRepository::class,
            ExchangeRateController::class=>ExchangeRatesRepository::class,
            ConsigneeController::class=> ConsigneesRepository::class,
            CustomHouseController::class=> CustomHousesRepository::class,
            ManifestController::class=> ManifestRepository::class,
            RoleController::class=> RolesRepository::class,
            TypeManifestDocumentController::class=> TypesManifestsDocumentsRepository::class,
            PermissionController::class=> PermissionsRepository::class,
        ];
      
      $serviceBindings = [
            FractionController::class => ImportFraction::class,
            DetailFractionController::class => ImportDetailFraction::class,

        ];
        
      foreach ($controllerBindings as $controller => $repository) {
            $this->app->when($controller)
                ->needs(ISearchAndPaginate::class)
                ->give($repository);
        }
        
        foreach ($serviceBindings as $controller => $service) {
            $this->app->when($controller)
                ->needs(ImportFileContract::class)
                ->give($service);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
