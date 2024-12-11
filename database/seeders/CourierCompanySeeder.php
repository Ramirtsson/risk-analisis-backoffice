<?php

namespace Database\Seeders;

use App\Models\CourierCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CourierCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/CourierCompany.json');
        $CourierCompany = json_decode($file, true);
        foreach ($CourierCompany as $courier) {
            (new CourierCompany())->create([
                'social_reason' => $courier['social_reason'],
                'tax_domicile' => $courier['tax_domicile'],
                'tax_id' => $courier['tax_id'],
                'validity' => $courier['validity'],
                'registration' => $courier['registration'],
                'status_id' => 1,
                'user_id' => 1
            ]);
        }

    }
}
