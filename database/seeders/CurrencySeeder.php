<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/currencies.json');
        $collection = json_decode($file, true);
        foreach ($collection as $item) {
            (new Currency())->create([
                'prefix' => $item['prefix'],
                'status_id' => $item['status_id'],
                'description' => $item['description'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
