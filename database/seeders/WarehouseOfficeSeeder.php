<?php

namespace Database\Seeders;

use App\Models\WarehouseOffice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WarehouseOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/warehouses_office.json');
        $store = json_decode($file, true);
        foreach ($store as $stores) {
            (new WarehouseOffice())->create([
                'name' => $stores['name'],
                'status_id' => $stores['status'],
                'user_id' => $stores['user_id']
            ]);
        }
    }
}
