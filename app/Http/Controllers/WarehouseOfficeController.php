<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseOfficesRequest;
use App\Models\WarehouseOffice;
use App\Http\Requests\UpdateWarehouseOfficeRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseOfficeController extends Controller
{
    protected ISearchAndPaginate $repository;

    public function __construct(ISearchAndPaginate $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @OA\Get(
     *     path="/api/warehouseOffice",
     *     summary="Listado y paginado de Almacenes",
     *     tags={"WarehouseOffice"},
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
     *         description="Buscar por nombre o status",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Nombre del almacen"
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
     *         description="Listado de tráficos",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nombre del almacen"),
     *                 @OA\Property(property="status", type="string", example="A"),
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
    public function index(Request $request): JsonResponse
    {
        $results = $this->repository->searchAndPaginate($request);
        return response()->json($results);
    }


    /**
     * @OA\Post(
     *     path="/api/warehouseOffice",
     *     summary="Crear un nuevo almacen",
     *     description="Crea un nuevo registro de alamcen con los campos proporcionados.",
     *     tags={"WarehouseOffice"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Almacen"),
     *             @OA\Property(property="status", type="string", example="A"),
     *             @OA\Property(property="user_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *           response=201,
     *           description="El almacén se creó correctamente.",
     *           @OA\JsonContent(
     *               @OA\Property(property="status", type="boolean"),
     *               @OA\Property(property="data", type="object"),
     *               @OA\Property(property="message", type="string", example="El almacén se creó correctamente.")
     *           )
     *       ),
     *       @OA\Response(
     *           response=422,
     *           description="Error de validación"
     *       )
     * )
     */
    public function store(StoreWarehouseOfficesRequest $request): JsonResponse
    {
        $warehouse = WarehouseOffice::create($request->all());

        return response()->json([
            'status' => true,
            'data' => $warehouse,
            'message' => 'El almacén se creó correctamente.'
        ], 201);
    }


    /**
     *   @OA\Put(
     *      path="/api/warehouseOffice/{id}",
     *      summary="Actualizar Almacén",
     *      tags={"Almacenes"},
     *      description="Actualiza un almacén existente por ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID del almacén a actualizar",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="Nombre del almacén"),
     *              @OA\Property(property="status", type="string", description="Estado del almacén 1-Activo 2-Inactivo", example="1"),
     *              @OA\Property(property="user_id", type="integer", description="ID del usuario que actualiza el almacén")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="El almacén se actualizó correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean"),
     *              @OA\Property(property="data", type="object"),
     *              @OA\Property(property="message", type="string", example="El almacén se actualizó correctamente.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="El almacén no fue encontrado."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error de validación"
     *      )
     *   )
     */
    public function update(UpdateWarehouseOfficeRequest $request, $id): JsonResponse
    {
        $warehouse = WarehouseOffice::find($id);

        if (!$warehouse) {
            return response()->json([
                'status' => false,
                'message' => 'El almacén no fue encontrado.'
            ], 404);
        }

        $warehouse->update($request->validated());

        return response()->json([
            'status' => true,
            'data' => $warehouse,
            'message' => 'El almacén se actualizó correctamente.'
        ], 200);
    }
    public function changeStatus($id, $status): JsonResponse
    {
        $model = WarehouseOffice::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    public function activeRecords(): JsonResponse
    {
        $collection = WarehouseOffice::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }
}
