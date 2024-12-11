<?php

namespace App\Http\Controllers;

use App\Models\ProductLevel;
use App\Http\Requests\StoreProductLevelRequest;
use App\Http\Requests\UpdateProductLevelRequest;
use Illuminate\Http\JsonResponse;

class ProductLevelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/product-levels/active-records",
     *     summary="Listado nivel de productos",
     *     tags={"Nivel de Productos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de Conceptos-T activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="1", type="string", example="Prohibido"),
     *             @OA\Property(property="2", type="string", example="Revisar"),
     *             @OA\Property(property="3", type="string", example="Despachado"),
     *             @OA\Property(property="status", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function activeRecords(): JsonResponse
    {
        $activeUsers = ProductLevel::where('status_id', 1)->select('name','id')->get();
        return response()->json($activeUsers);
    }
}
