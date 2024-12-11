<?php

namespace App\Http\Controllers;

use App\Models\TypePayment;
use App\Http\Requests\StoreTypePaymentRequest;
use App\Http\Requests\UpdateTypePaymentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PaymentTypeController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/payment-types",
     *     summary="Listado tipos de pago",
     *     description="Listado tipos de pago.",
     *     tags={"Tipos de Pago"},
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
    public function __invoke():JsonResponse
    {
        $collection = DB::table('value_types')->select('id', 'name')->get();
        return response()->json($collection);
    }
}
