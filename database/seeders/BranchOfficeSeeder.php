<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BranchOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/branches.json');
        $branches = json_decode($file, true);
        foreach ($branches as $branch) {
            (new Branch())->create([
                'name' => $branch['name'],
                'status_id' => $branch['status_id'],
                'address' => $branch['address'],
                'user_id' => $branch['user_id'],
            ]);
        }
    }
}
