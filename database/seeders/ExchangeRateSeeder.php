<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/exchange_rates.json');
        $items = json_decode($file, true);
        foreach ($items as $item) {
            (new ExchangeRate())->create([
                'exchange' => $item['exchange'],
                'date' => $item['date'],
                'status_id' => $item['status_id'],
                'user_id' => $item['user_id']
            ]);
        }
    }
}
