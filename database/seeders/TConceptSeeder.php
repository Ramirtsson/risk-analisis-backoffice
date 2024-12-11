<?php

namespace Database\Seeders;

use App\Models\TConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/t-concepts.json');
        $collection = json_decode($file, true);
        foreach ($collection as $item) {
            (new TConcept())->create([
                'name' => $item['name'],
                'status_id' => $item['status_id'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
