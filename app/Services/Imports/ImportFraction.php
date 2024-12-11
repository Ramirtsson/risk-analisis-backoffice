<?php

namespace App\Services\Imports;

use App\Models\DetailFraction;
use App\Models\Fraction;
use App\Services\Contracts\ImportFileContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportFraction implements ImportFileContract
{
    public function importFile(Request $request)
    {
        collect($request->validated()["fractions"])->each(function ($item) {
                Fraction::updateOrInsert(
                    ['name' => $item['name']],
                    [
                    'description' => $item['description'],
                    'level_product_id' => $item['level_product_id'], 
                    'status_id' => $item['status_id'], 
                    'user_id' => Auth::id()
                    ]
                );
            });
        return response()->json(['message' => 'Todos los elementos fueron registrados correctamente.']);
    }
}