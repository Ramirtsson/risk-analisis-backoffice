<?php

namespace Database\Seeders;

use App\Models\ApplicationConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ApplicationConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/applicationConcept.json');
        $concepts = json_decode($file, true);
        foreach($concepts as $concept) {
            (new ApplicationConcept())->create([
                'name' => $concept['name'],
                'status_id' => $concept['status_id'],
                'user_id' => $concept['user_id'],
            ]);
        }
    }
}
