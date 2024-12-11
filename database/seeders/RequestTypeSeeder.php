<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTypeSeeder extends Seeder
{
    private array $items = [
        'Anticipo',
        'Solicitud'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            DB::table('request_types')->insert([
                'name' => $item,
            ]);
        }
    }
}
