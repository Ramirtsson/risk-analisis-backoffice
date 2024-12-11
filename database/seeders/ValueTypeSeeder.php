<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValueTypeSeeder extends Seeder
{

    private array $items = ['BAJO', 'ALTO'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item){
            DB::table('value_types')->insert([
                'name'  => $item
            ]);
        }
    }
}
