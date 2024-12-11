<?php

namespace App\Http\Controllers;

use App\Models\PaymentConcept;
use App\Http\Requests\StorePaymentConceptRequest;
use App\Http\Requests\UpdatePaymentConceptRequest;
use Illuminate\Http\JsonResponse;

class PaymentConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentConceptRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentConceptRequest $request, PaymentConcept $paymentConcept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentConcept $paymentConcept)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/payment-concepts/active-records",
     *     summary="Obtener listado conceptos de pago",
     *     description="Devuelve listado conceptos de pago activos.",
     *     tags={"Conceptos de Pago"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="status_id", type="string"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
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
        $data = PaymentConcept::where('status_id', 1)->orderBy('name', 'asc')->get(['id', 'name']);;
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/payment-concepts/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Conceptos de Pago"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="status_id", type="integer"),
     *                     @OA\Property(property="user_id", type="integer"),
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
    public function changeStatus($id, $status): JsonResponse
    {
        $model = PaymentConcept::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
}
