<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WarehousesOriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonPath = database_path('data/warehouses.json');
        $json = File::get($jsonPath);
        $warehouses = json_decode($json, true);
        DB::table('warehouses_origin')->insert($warehouses);
    }
}
