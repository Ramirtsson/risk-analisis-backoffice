<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeManifestDocumentSeeder extends Seeder
{
    private array $items = [
        'PEDIMENTO',
        'CUENTA DE GASTOS',
        'FACTURA',
        'GUIA AEREA',
        'EXPEDIENTE DIGITAL',
        'DOCUMENTOS CUENTAS DE GASTOS EJECUTIVO',
        'EVIDENCIA PREVIOS',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item){
            DB::table('type_manifest_documents')->insert([
               'name' => $item,
               'status_id' => 1,
               'user_id' => 1
            ]);
        }
    }
}
