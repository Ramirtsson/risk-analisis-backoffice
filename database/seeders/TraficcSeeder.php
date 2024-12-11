<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Traficc;
use Illuminate\Support\Facades\File;

class TraficcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/traficc-type.json');
        $collection = json_decode($file, true);
        foreach ($collection as $item) {
            (new Traficc())->create([
                'name' => $item['name'],
                'status_id' => $item['status_id'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
