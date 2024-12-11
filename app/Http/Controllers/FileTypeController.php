<?php

namespace App\Http\Controllers;

use App\Models\FileType;
use Illuminate\Http\JsonResponse;

class FileTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/file-types/active-records",
     *     summary="Listado de tipos de archivos solicitudes de pago estatus activo",
     *     description="Devuelve un listado de tipos de archivos solicitudes de pago estatus activo.",
     *     tags={"Tipos de archivo solicitudes de pago"},
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
        $collection = FileType::select('name', 'id')->get();
        return response()->json($collection);
    }
}
