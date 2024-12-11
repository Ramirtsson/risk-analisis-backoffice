<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use App\Http\Requests\StorepaymentRequestRequest;
use App\Http\Requests\UpdatepaymentRequestRequest;
use App\Models\PaymentRequestDocument;
use App\Services\Images\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/payment-requests",
     *     summary="Crear una nueva solicitud de pago",
     *     description="Crea una nueva solicitud de pago con la información proporcionada, incluyendo los documentos asociados.",
     *     tags={"Solicitudes de pago"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={
     *                     "manifest_id", 
     *                     "account_id", 
     *                     "request_type_id", 
     *                     "payment_information[tconcept_id]", 
     *                     "payment_information[payment_amount]", 
     *                     "payment_information[currency_id]", 
     *                     "documents[0][file_type_id]", 
     *                     "documents[0][file]"
     *                 },
     *                 @OA\Property(
     *                     property="manifest_id",
     *                     type="integer",
     *                     description="ID del manifiesto.",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="account_id",
     *                     type="integer",
     *                     description="ID de la cuenta asociada.",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="request_type_id",
     *                     type="integer",
     *                     description="ID del tipo de solicitud.",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="payment_information[tconcept_id]",
     *                     type="integer",
     *                     description="ID del concepto de pago.",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="payment_information[observations]",
     *                     type="string",
     *                     description="Observaciones adicionales sobre la solicitud.",
     *                     example="Observación de ejemplo"
     *                 ),
     *                 @OA\Property(
     *                     property="payment_information[payment_amount]",
     *                     type="number",
     *                     format="float",
     *                     description="Monto del pago.",
     *                     example=124.34
     *                 ),
     *                 @OA\Property(
     *                     property="payment_information[currency_id]",
     *                     type="integer",
     *                     description="ID de la moneda.",
     *                     example=2
     *                 ),
     *                 @OA\Property(
     *                     property="documents[0][file_type_id]",
     *                     type="integer",
     *                     description="ID del tipo de archivo para el primer documento.",
     *                     example=2
     *                 ),
     *                 @OA\Property(
     *                     property="documents[0][file]",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo para el primer documento."
     *                 ),
     *                 @OA\Property(
     *                     property="documents[1][file_type_id]",
     *                     type="integer",
     *                     description="ID del tipo de archivo para el segundo documento.",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="documents[1][file]",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo para el segundo documento."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Solicitud de pago creada con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 description="ID de la solicitud de pago creada.",
     *                 example=101
     *             ),
     *             @OA\Property(
     *                 property="manifest_id",
     *                 type="integer",
     *                 description="ID del manifiesto.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="account_id",
     *                 type="integer",
     *                 description="ID de la cuenta asociada.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="request_type_id",
     *                 type="integer",
     *                 description="ID del tipo de solicitud.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="status_id",
     *                 type="integer",
     *                 description="Estado de la solicitud.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="tconcept_id",
     *                 type="integer",
     *                 description="ID del concepto de pago.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="observations",
     *                 type="string",
     *                 description="Observaciones adicionales sobre la solicitud.",
     *                 example="Observación de ejemplo"
     *             ),
     *             @OA\Property(
     *                 property="payment_amount",
     *                 type="number",
     *                 format="float",
     *                 description="Monto del pago.",
     *                 example=124.34
     *             ),
     *             @OA\Property(
     *                 property="currency_id",
     *                 type="integer",
     *                 description="ID de la moneda.",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 description="ID del usuario que realizó la solicitud.",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error de validación"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 additionalProperties={
     *                     "type": "array",
     *                     "items": {
     *                         "type": "string",
     *                         "example": "El campo manifiesto es obligatorio."
     *                     }
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error al guardar la solicitud de pago"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Detalles del error técnico"
     *             )
     *         )
     *     )
     * )
     */
    public function store(StorepaymentRequestRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $paymentRequest = PaymentRequest::create([
                'manifest_id' => $request->input('manifest_id'),
                'account_id' => $request->input('account_id'),
                'request_type_id' => $request->input('request_type_id'),
                'status_id' => 1,
                'tconcept_id' => $request->input('payment_information.tconcept_id'),
                'observations' => $request->input('payment_information.observations'),
                'payment_amount' => $request->input('payment_information.payment_amount'),
                'currency_id' => $request->input('payment_information.currency_id'),
                'user_id' => Auth::id(),
            ]);
            
            if ($request->has('documents')) {
                foreach ($request->input('documents', []) as $index => $document) {
                    $file = $request->file("documents.$index.file");
                    $ruta = (new ImageService('public', '/payment_requests'))->store($file);

                    PaymentRequestDocument::create([
                        'payment_request_id' => $paymentRequest->id,
                        'file_type_id' => $document["file_type_id"],
                        'path' => $ruta,
                        'file_name' => $file->getClientOriginalName(),
                        'status_id' => 1,
                        'user_id' => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            return response()->json($paymentRequest, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => 'Error al guardar la solicitud de pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(paymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(paymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequestRequest $request, paymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paymentRequest $paymentRequest)
    {
        //
    }
}
