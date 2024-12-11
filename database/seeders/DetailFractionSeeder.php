<?php

namespace Database\Seeders;

use App\Models\Fraction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\DetailFraction;

class DetailFractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$file = File::get('database/data/detail-fractions.json');
        $store = json_decode($file, true);
        foreach ($store as $stores) {
            (new DetailFraction())->create([
                'name' => $stores['name'],
                'fraction_id' => $stores['fraction_id'],
                'status_id' => $stores['status_id'],
                'user_id' => $stores['user_id']
            ]);
        }*/

        Fraction::factory()->count(50)->create()->each(function ($detailFraction) {
           DetailFraction::factory()->count(5)->create(['fraction_id' => $detailFraction->id]);
        });
    }
}
