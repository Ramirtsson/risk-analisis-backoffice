<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/suppliers",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Proveedores"},
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
     *         description="Búscar por nombre o status",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="KWT INTERNATIONAL TRADING LIMITED"
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
     *         description="---",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="code", type="string"),
     *                 @OA\Property(property="rfc", type="string"),
     *                 @OA\Property(property="zip_code", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="country_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object"),
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
     * @OA\Post(
     *     path="/api/suppliers",
     *     summary="Crear un nuevo registro de Proveedor",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Proveedores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "code","rfc","address","city","status_id","zip_code","country_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="code", type="string", example="123"),
     *             @OA\Property(property="rfc", type="string", example="QW2342"),
     *             @OA\Property(property="address", type="string", example="address"),
     *             @OA\Property(property="city", type="string", example="city"),
     *             @OA\Property(property="zip_code", type="string", example="1234"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="country_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="code", type="string", example="123"),
     *             @OA\Property(property="rfc", type="string", example="QW2342"),
     *             @OA\Property(property="address", type="string", example="address"),
     *             @OA\Property(property="city", type="string", example="city"),
     *             @OA\Property(property="zip_code", type="string", example="1234"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="country_id", type="string", example="1"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = Supplier::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/suppliers/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Proveedor existente.",
     *     tags={"Proveedores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "code","rfc","zip_code","city","address","status_id","country_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="code", type="string", example="122"),
     *             @OA\Property(property="rfc", type="string", example="EQ231"),
     *             @OA\Property(property="zip_code", type="string", example="34232"),
     *             @OA\Property(property="city", type="string", example="city"),
     *             @OA\Property(property="address", type="string", example="address"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="country_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor actualizado correctamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registro no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Datos inválidos")
     *         )
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

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $supplier->update($data);
        return response()->json("Proveedor actualizado correctamente");
    }

    /**
     * @OA\Patch(
     *     path="/api/suppliers/{id}/status/{status}",
     *     summary="Marcar un registro de Proveedor como inactivo o activo.",
     *     description="Actualiza el estado de una Proveedor a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Proveedores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *         @OA\Parameter(
     *         name="status",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="code", type="string"),
     *                 @OA\Property(property="rfc", type="string"),
     *                 @OA\Property(property="zip_code", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="country_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object"),
     *         ),
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proveedor no encontrado."
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
        $model = Supplier::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/suppliers/active-records",
     *     summary="Listado de Provedores con estatus activo",
     *     description="Devuelve un listado de Provedores con estatus activo.",
     *     tags={"Proveedores"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="status", type="string"),
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
        $collection = Supplier::where('status_id', 1)->get(['name', 'code', 'id']);
        return response()->json($collection);
    }
}
