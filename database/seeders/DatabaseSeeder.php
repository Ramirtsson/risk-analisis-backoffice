<?php

namespace Database\Seeders;


use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
        ]);

        $user = User::create(array(
            'name' => "ADMIN_1",
            'password' => "12345678",
            'status_id' => 1,
        ));
        $user->assignRole('Administrador');

        $this->call(BranchOfficeSeeder::class);

        Profile::create([
            'name' => 'Diego Israel',
            'last_name' => 'Han',
            'second_lastname' => 'Enríquez',
            "email" => "gerencia.desarrollo@nexen-elog.com",
            'branch_id' => 1,
            'user_id' => $user->id,
        ]);


        $this->call([
            GuestUserSeeder::class,
            CourierCompanySeeder::class,
            ClientTypeSeeder::class,
            WarehousesOriginSeeder::class,
            WarehouseOfficeSeeder::class,
            ApplicationConceptSeeder::class,
            CurrencySeeder::class,
            TConceptSeeder::class,
            TraficcSeeder::class,
            CustomsAgentSeeder::class,
            CountrySeeder::class,
            SupplierSeeder::class,
            UnitMeasuresSeeder::class,
            LevelProductSeeder::class,
            KasaSystemKeySeeder::class,
            ExchangeRateSeeder::class,
            ValueTypeSeeder::class,
            OperatingStatusSeeder::class,
            PaymentTypeSeeder::class,
            PaymentConceptSeeder::class,
            TypeManifestDocumentSeeder::class,
            FileTypeSeeder::class,
            RequestTypeSeeder::class,
            ProductLevelSeeder::class,
        ]);

    }
}
