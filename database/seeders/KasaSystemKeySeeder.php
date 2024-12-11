<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KasaSystemKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kasa_system_keys')->insert([
            [
                'code' => "MC",
                'name' => "MARCA",
                'status_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => "EN",
                'name' => "NO APLICACIÓN DE LA NORMA OFICIAL MEXICANA.",
                'status_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => "XP",
                'name' => "EXCEPCION AL CUMPLIMIENTO DE REGULACIÓN Y RESTRICCIONES NO ARANCELARIAS.",
                'status_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => "DH",
                'name' => "DATOS DE IMPORTACIÓN HIDROCARBUROS",
                'status_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
