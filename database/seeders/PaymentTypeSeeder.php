<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    private array $paymentTypes = ['ANTICIPO', 'FINANCIADO'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->paymentTypes as $paymentType) {
            DB::table('payment_types')->insert([
                'name' => $paymentType,
            ]);
        }
    }
}
