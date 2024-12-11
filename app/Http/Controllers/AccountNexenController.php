<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AccountNexenController extends Controller
{
    public function activeRecords(): JsonResponse
    {
        $collection = DB::connection('nexen_db')
            ->table('Razon_Bancos as R')
            ->select([
                'R.id_Movimiento',
                'E.Razon_Social AS Razon_Social_Empresa',
                'E.ID_EMPRESA',
                'P.alias',
                'P.Razon_Social',
                'P.RFC',
                'C.NOMBRE_BANCO',
                'R.Cuenta',
                'R.Clabe',
                'R.SWT_ABBA',
                'R.Banco_Intermediario',
                'R.Domicilio_Completo',
                'P.Ref_Proveedor',
            ])
            ->distinct()
            ->join('Proveedores_Cuentas as P', 'P.id_Razon', '=', 'R.id_razon_social')
            ->join('FK_Operador_Razon as O', function ($join) {
                $join->on('O.Id_Razon_Social', '=', 'R.id_razon_social')
                    ->on('O.Id_Razon_Social', '=', 'P.Id_Razon');
            })
            ->join('EMPRESAS as E', 'E.ID_EMPRESA', '=', 'O.Id_Operador')
            ->join('Catalogo_Bancos as C', 'C.ID_BANCO', '=', 'R.Id_banco')
            ->where('E.ID_EMPRESA', '7')
            ->get();

        return response()->json($collection);
    }

    public function accountsById($id): JsonResponse
    {
        $collection = DB::connection('nexen_db')
            ->table('Proveedores_Cuentas as PC')
            ->select([
                'PC.Alias',
                'RB.Clabe',
                'RB.Cuenta',
                'RB.Tipo_Cuenta',
                'RB.SWT_ABBA',
                'RB.Banco_Intermediario',
                'RB.Domicilio_Completo',
                'RB.id_Movimiento',
                'C.NOMBRE_BANCO',
                'PC.Razon_Social AS Razon_Social',
                'PC.RFC',
            ])
            ->distinct()
            ->join('Razon_Bancos as RB', 'RB.Id_Razon_Social', '=', 'PC.id_Razon')
            ->join('Catalogo_Bancos as C', 'C.ID_BANCO', '=', 'RB.Id_banco')
            ->where('RB.id_Movimiento', $id)
            ->get();

        return response()->json($collection);
    }
}
