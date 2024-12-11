<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use Illuminate\Http\JsonResponse;

class RequestTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/request-types/active-records",
     *     summary="Listado tipos de solicitudes de pago",
     *     description="Devuelve listado tipos solicitudes de pago",
     *     tags={"Tipos de solicitudes de pago"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
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
        $collection = RequestType::select('name', 'id')->get();
        return response()->json($collection);
    }
}
