<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Http\Requests\StoreCustomersRequest;
use App\Http\Requests\UpdateCustomersRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomersController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Listado paginado de clientes",
     *     tags={"Clientes"},
     *     @OA\SecurityScheme(
     *         type="http",
     *         description="Bearer Token",
     *         name="Authorization",
     *         in="header",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         securityScheme="bearerAuth",
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Buscar por razón social o estado",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Empresa XYZ"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Número de elementos por página",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=10
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="current_page",
     *         in="query",
     *         description="Página actual",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de clientes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="customer_type", type="integer", example=1),
     *                 @OA\Property(property="social_reason", type="string", example="Empresa XYZ"),
     *                 @OA\Property(property="tax_domicile", type="string", example="Calle Falsa 123, Ciudad, País"),
     *                 @OA\Property(property="tax_id", type="string", example="ABC123456"),
     *                 @OA\Property(property="phone_1", type="string", example="1234567890"),
     *                 @OA\Property(property="phone_2", type="string", example="0987654321"),
     *                 @OA\Property(property="mail_1", type="string", example="contacto@empresa.xyz"),
     *                 @OA\Property(property="mail_2", type="string", example="soporte@empresa.xyz"),
     *                 @OA\Property(property="status_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1)
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
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
    public function index(Request $request)
    {
        return $this->repository->searchAndPaginate($request);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/active-records",
     *     summary="Lista de clientes activos",
     *     tags={"Clientes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="social_reason", type="string", example="Empresa XYZ")
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
    public function activeRecords(Request $request): JsonResponse
    {
        $activeUsers = Customers::where('status_id', 1)->pluck('social_reason', 'id');
        return response()->json($activeUsers, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Crear un nuevo cliente",
     *     description="Crea un nuevo registro de cliente con los campos proporcionados.",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="customer_type", type="integer", example=1),
     *             @OA\Property(property="social_reason", type="string", example="Empresa XYZ"),
     *             @OA\Property(property="tax_domicile", type="string", example="Calle Falsa 123, Ciudad, País"),
     *             @OA\Property(property="tax_id", type="string", example="ABC123456"),
     *             @OA\Property(property="phone_1", type="string", example="1234567890"),
     *             @OA\Property(property="phone_2", type="string", example="0987654321"),
     *             @OA\Property(property="mail_1", type="string", example="contacto@empresa.xyz"),
     *             @OA\Property(property="mail_2", type="string", example="soporte@empresa.xyz"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="customer_type", type="integer", example=1),
     *             @OA\Property(property="social_reason", type="string", example="Empresa XYZ"),
     *             @OA\Property(property="tax_domicile", type="string", example="Calle Falsa 123, Ciudad, País"),
     *             @OA\Property(property="tax_id", type="string", example="ABC123456"),
     *             @OA\Property(property="phone_1", type="string", example="1234567890"),
     *             @OA\Property(property="phone_2", type="string", example="0987654321"),
     *             @OA\Property(property="mail_1", type="string", example="contacto@empresa.xyz"),
     *             @OA\Property(property="mail_2", type="string", example="soporte@empresa.xyz"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-11T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-11T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bad Request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de validación incorrectos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unprocessable Entity"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="customer_type", type="array", @OA\Items(type="string", example="Tipo de cliente es requerido.")),
     *                 @OA\Property(property="social_reason", type="array", @OA\Items(type="string", example="Razón social es requerida.")),
     *                 @OA\Property(property="tax_domicile", type="array", @OA\Items(type="string", example="Domicilio fiscal es requerido.")),
     *                 @OA\Property(property="tax_id", type="array", @OA\Items(type="string", example="RFC es requerido.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado es requerido.")),
     *                 @OA\Property(property="user_id", type="array", @OA\Items(type="string", example="ID de usuario es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreCustomersRequest $request)
    {
        $model = Customers::create($request->all());
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Actualizar un cliente existente",
     *     description="Actualiza un registro de cliente existente con los campos proporcionados.",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del cliente a actualizar"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="customer_type", type="integer", example=1),
     *             @OA\Property(property="social_reason", type="string", example="Empresa XYZ Editado"),
     *             @OA\Property(property="tax_domicile", type="string", example="Calle Falsa 123, Ciudad, País Editado"),
     *             @OA\Property(property="tax_id", type="string", example="ABC123456"),
     *             @OA\Property(property="phone_1", type="string", example="1234567890"),
     *             @OA\Property(property="phone_2", type="string", example="0987654321"),
     *             @OA\Property(property="mail_1", type="string", example="contacto@empresa.com"),
     *             @OA\Property(property="mail_2", type="string", example="soporte@empresa.com"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="customer_type", type="integer", example=1),
     *             @OA\Property(property="social_reason", type="string", example="Empresa XYZ Editado"),
     *             @OA\Property(property="tax_domicile", type="string", example="Calle Falsa 123, Ciudad, País Editado"),
     *             @OA\Property(property="tax_id", type="string", example="ABC123456"),
     *             @OA\Property(property="phone_1", type="string", example="1234567890"),
     *             @OA\Property(property="phone_2", type="string", example="0987654321"),
     *             @OA\Property(property="mail_1", type="string", example="contacto@empresa.com"),
     *             @OA\Property(property="mail_2", type="string", example="soporte@empresa.com"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-11T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-11T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bad Request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Not Found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de validación incorrectos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unprocessable Entity"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="customer_type", type="array", @OA\Items(type="string", example="Tipo de cliente es requerido.")),
     *                 @OA\Property(property="social_reason", type="array", @OA\Items(type="string", example="Razón social es requerida.")),
     *                 @OA\Property(property="tax_domicile", type="array", @OA\Items(type="string", example="Domicilio fiscal es requerido.")),
     *                 @OA\Property(property="tax_id", type="array", @OA\Items(type="string", example="RFC es requerido.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado es requerido.")),
     *                 @OA\Property(property="user_id", type="array", @OA\Items(type="string", example="ID de usuario es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateCustomersRequest $request, int $id)
    {
        $model = Customers::where('id', $id)->firstOrFail();
        $model->update($request->all());
        return response()->json($model);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Cambiar el estado de un cliente entre activo e inactivo.",
     *     description="Actualiza el estado de un cliente a inactivo (I) si está activo (A), y a activo (A) si está inactivo (I).",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado del cliente actualizado exitosamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente inactivo.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function changeStatus($id, $status): JsonResponse
    {
        $model = Customers::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    
}
