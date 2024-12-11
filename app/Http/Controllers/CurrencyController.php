<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currencies/active-records",
     *     summary="Obtener listado estado activo",
     *     description="Devuelve un listado estado activas (status_id = 1).",
     *     tags={"Moneda"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado estado activo",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="prefix", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron registros en base de datos."
     *     ),
     *          @OA\Response(
     *          response=401,
     *          description="Credenciales incorrectas",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      )
     * )
     */
    public function activeRecords(): JsonResponse
    {
        $collection = Currency::where('status_id', 1)->get(['id', 'prefix', 'description']);
        return response()->json($collection);
    }
}
