<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CustomHouse;

class CustomHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/customs_houses.json');
        $customHouses = json_decode($file, true);
        foreach ($customHouses as $customHouse) {
            CustomHouse::create([
                'name' => $customHouse['name'],
                'code' => $customHouse['code'],
                'status_id' => $customHouse['status_id'],
                'user_id' => $customHouse['user_id'],
            ]);
        }
    }
}
