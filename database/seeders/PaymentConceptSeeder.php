<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentConceptSeeder extends Seeder
{

    private array $paymentConcepts = [
        'Revalidación de Guias',
        'Servicios Extraordinarias',
        'Impuestos y Honorarios',
        'Otros',
        'Desconsolidación',
        'Maniobras',
        'Rectificación',
        'Anticipos',
        'Anticipo o Preforma'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->paymentConcepts as $paymentConcept) {
            DB::table('payment_concepts')->insert([
                'name' => $paymentConcept,
                'status_id' => 1,
                'user_id' => 1,
            ]);
        }
    }
}
