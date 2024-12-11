<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operating_statuses')->insert([
            [

                'name' => "PreAlerta",
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Abierto",
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Cerrado",
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Cerrado por ejecutivo",
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Cerrado por facturación",
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
