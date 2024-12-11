<?php

namespace Database\Seeders;

use App\Models\SystemModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemModule::factory()->count(50)->create();
    }
}
