<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomersSeeder extends Seeder
{

    public function run(): void
    {
        Customers::factory()->count(3)->create();
    }
}
