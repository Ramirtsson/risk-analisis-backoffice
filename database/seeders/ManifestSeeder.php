<?php

namespace Database\Seeders;

use App\Models\Manifest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManifestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manifest::factory()->count(50)->create()->each(fn(Manifest $manifest) => [
            DB::table('m_files')->insert([
                'name' => 'XXXX.txt',
                'manifest_id' => $manifest->id,
                'user_id' => 1,
            ])
        ]);
    }
}
