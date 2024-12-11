<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/suppliers.json');
        $collection = json_decode($file, true);
        foreach ($collection as $item) {
            (new Supplier())->create([
                'name' => $item['name'],
                'code' => $item['code'],
                'rfc' => $item['rfc'],
                'status_id' => $item['status_id'],
                'zip_code' => $item['zip_code'],
                'city' => $item['city'],
                'address' => $item['address'],
                'country_id' => $item['country_id'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
