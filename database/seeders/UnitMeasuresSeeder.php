<?php

namespace Database\Seeders;

use App\Models\UnitMeasure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UnitMeasuresSeeder extends Seeder
{
    
    public function run(): void
    {
        $jsonPath = database_path('data/UnitMeasures.json');
        $json = File::get($jsonPath);
        $UnitMeasures = json_decode($json, true);
        DB::table('unit_measures')->insert($UnitMeasures);
    }
}
