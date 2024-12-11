<?php

namespace Database\Seeders;

use App\Models\Consignee;
use Illuminate\Database\Seeder;

class ConsigneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Consignee::factory()->count(50)->create();
    }
}
