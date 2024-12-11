<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Fraction;

class FractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/fractions.json');
        $store = json_decode($file, true);
        foreach ($store as $stores) {
            (new Fraction())->create([
                'name' => $stores['name'],
                'description' => $stores['description'],
                'level_product_id' => $stores['level_product_id'],
                'status_id' => $stores['status_id'],
                'user_id' => $stores['user_id']
            ]);
        }
    }
}
