<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    private array $items = [
        'Anticipo',
        'Proforma',
        'Solicitud',

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            DB::table('file_types')->insert([
                'name' => $item,
            ]);
        }
    }
}
