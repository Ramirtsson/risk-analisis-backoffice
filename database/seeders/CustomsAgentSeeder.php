<?php

namespace Database\Seeders;

use App\Models\CustomsAgent;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomsAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get('database/data/CustomAgent.json');
        $store = json_decode($file, true);
        foreach ($store as $stores) {
            (new CustomsAgent())->create([
                'name' => $stores['name'],
                'patent' => $stores['patent'],
                'status_id' => $stores['status_id'],
                'user_id' => $stores['user_id']
            ]);
        }
    }
}
