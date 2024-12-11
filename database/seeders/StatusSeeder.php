<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    private array $statuses = ['Activo', 'Baja'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status,
            ]);
        }
    }
}
