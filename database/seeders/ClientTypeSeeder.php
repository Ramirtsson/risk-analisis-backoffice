<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\ClientType;

class ClientTypeSeeder extends Seeder
{
    public function run(): void
    {
        $file = File::get('database/data/ClientType.json');
        $clientTypes = json_decode($file, true);
        foreach ($clientTypes as $clientType) {
            ClientType::create([
                'name' => $clientType['name'],
                'status' => $clientType['status'],
            ]);
        }
    }
}
