<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/countries.json');
        $collection = json_decode($file, true);
        foreach ($collection as $item) {
            (new Country())->create([
                'code' => $item['code'],
                'name' => $item['name'],
                'status_id' => $item['status_id'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
