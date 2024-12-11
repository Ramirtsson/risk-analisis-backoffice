<?php

namespace App\Services\Imports;

use App\Models\DetailFraction;
use App\Models\Fraction;
use App\Services\Contracts\ImportFileContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportDetailFraction implements ImportFileContract
{
    public function importFile(Request $request)
    {
        DB::beginTransaction();
        try {
            collect($request->validated()["detailFractions"])->each(function ($item) {
                $fraction = Fraction::where('name', $item['name'])->first();
                if (!$fraction) {
                    throw new \Exception("La fraccion: ".$item['name'].', no esta actualmente registrado');
                }

                DetailFraction::updateOrInsert(
                    ['name' => $item['description'],'fraction_id' => $fraction->id],
                    [
                        'fraction_id' => $fraction->id,
                        'name' => $item['description'],
                        'status_id' => $item['status_id'], 
                        'user_id' => Auth::id()
                    ]
                );

            });
            DB::commit();
            return response()->json(['message' => 'Todos los elementos fueron registrados correctamente.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}