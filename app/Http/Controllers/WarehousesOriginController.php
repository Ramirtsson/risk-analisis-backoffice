<?php

namespace App\Http\Controllers;

use App\Models\WarehousesOrigin;
use App\Http\Requests\WarehousesOriginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Support\Facades\Auth;

class WarehousesOriginController extends Controller
{
    protected $repository;

    public function __construct(ISearchAndPaginate $repository)
    {
        $this->repository = $repository;
    }

    /**
    *   @OA\Get(
    *      path="/api/warehouses",
    *      summary="Listar Almacenes",
    *      tags={"Almacenes"},
    *      description="Obtiene una lista de almacenes con búsqueda y paginación",
    *      @OA\Parameter(
    *          name="search",
    *          in="query",
    *          description="Texto para buscar en los nombres de los almacenes o usuarios",
    *          required=false,
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="per_page",
    *          in="query",
    *          description="Número de resultados por página",
    *          required=false,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="current_page",
    *          in="query",
    *          description="Número de página actual",
    *          required=false,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Listado de almacenes",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="data", type="array", @OA\Items(type="object")),
    *              @OA\Property(property="pagination", type="object")
    *          )
    *      ),
    *      @OA\Response(
    *          response=500,
    *          description="Error del servidor"
    *      )
    *   )
    */
    public function index(Request $request): JsonResponse
    {
        $results = $this->repository->searchAndPaginate($request);
        return response()->json($results);
    }

    /**
    *   @OA\Post(
    *      path="/api/warehouses",
    *      summary="Crear Almacén",
    *      tags={"Almacenes"},
    *      description="Crea un nuevo almacén",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              @OA\Property(property="name", type="string", description="Nombre del almacén"),
    *              @OA\Property(property="status_id", type="string", description="Estado del almacén (1 activo, 2 inactivo)", example="1"),
    *          )
    *      ),
    *      @OA\Response(
    *          response=201,
    *          description="El almacén se creó correctamente.",
    *          @OA\JsonContent(
    *              @OA\Property(property="status", type="boolean"),
    *              @OA\Property(property="data", type="object"),
    *              @OA\Property(property="message", type="string", example="El almacén se creó correctamente.")
    *          )
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="Error de validación"
    *      )
    *   )
    */
    public function store(WarehousesOriginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data["user_id"]=Auth::id();
        $warehouse = WarehousesOrigin::create($data);
    
        return response()->json([
            'status' => true,
            'data' => $warehouse,
            'message' => 'El almacén se creó correctamente.'
        ], 201);
    }

    /**
    *   @OA\Put(
    *      path="/api/warehouses/{id}",
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
    *              @OA\Property(property="status_id", type="string", description="Estado del almacén 1-Activo 2-Inactivo", example="1"),
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
    public function update(WarehousesOriginRequest $request, $id): JsonResponse
    {
        $warehouse = WarehousesOrigin::find($id);
    
        if (!$warehouse) {
            return response()->json([
                'status' => false,
                'message' => 'El almacén no fue encontrado.'
            ], 404);
        }
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $warehouse->update($data);
    
        return response()->json([
            'status' => true,
            'data' => $warehouse,
            'message' => 'El almacén se actualizó correctamente.'
        ], 200);
    }
        /**
     * @OA\Patch(
     *     path="/api/warehouses/{id}/status/{status}",
     *     summary="Marcar un registro de Almacen de origen como inactivo o activo.",
     *     description="Actualiza el estado de un almacen de origen a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Almacenes"},
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
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 )
     *             )),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empresa de Mensajeria no encontrado."
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
        $model = WarehousesOrigin::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/warehouses/active-records",
     *     summary="Listado de Almacenes de origen con estatus activo",
     *     description="Devuelve un listado de Almacenes de origen con estatus activo.",
     *     tags={"Almacenes"},
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
        $collection = WarehousesOrigin::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }
}
