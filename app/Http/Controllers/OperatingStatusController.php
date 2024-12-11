<?php

namespace App\Http\Controllers;

use App\Models\OperatingStatus;
use App\Http\Requests\StoreOperatingStatusRequest;
use App\Http\Requests\UpdateOperatingStatusRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OperatingStatusController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/operating-status",
     *     summary="Listado de estatus de operación paginados y ordenados de forma ascendente por id de registro.",
     *     tags={"Estatus de Operación"},
     *     @OA\SecurityScheme(
     *         type="http",
     *         description="Bearer Token",
     *         name="Authorization",
     *         in="header",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         securityScheme="bearerAuth",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                @OA\Items(
     *                    @OA\Property(property="id", type="integer", example=1),
     *                    @OA\Property(property="name", type="string", example="--"),
     *                    @OA\Property(property="status_id", type="integer", example="1")
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
     * @OA\Post(
     *     path="/api/operating-status",
     *     summary="Crear un nuevo registro.",
     *     description="Crea un nuevo registro en base de datos.",
     *     tags={"Estatus de Operación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "status_id"},
     *             @OA\Property(property="name", type="string", example="razon social"),
     *             @OA\Property(property="status_id", type="integer", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status_id", type="integer"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
     */
    public function store(StoreOperatingStatusRequest $request): JsonResponse
    {
        $query = OperatingStatus::create([
            'name' => $request->get('name'),
            'status_id' => $request->get('status_id'),
        ]);
        return response()->json($query);
    }

    /**
     * @OA\Put(
     *     path="/api/operating-status/{id}",
     *     summary="Actualizar registro",
     *     description="Actualiza la información especifica de un registro.",
     *     tags={"Estatus de Operación"},
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
     *             @OA\Property(property="name", type="string", example="---"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="---"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="---"
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="---",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized")
     *           )
     *       )
     * )
     */
    public function update(UpdateOperatingStatusRequest $request, $id): JsonResponse
    {
        $model = OperatingStatus::findOrFail($id);
        $model->name = $request->get('name');
        $model->status_id = $request->get('status_id');
        $model->save();

        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/operating-status/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Estatus de Operación"},
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
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="---"
     *     ),
     *          @OA\Response(
     *          response=401,
     *          description="---",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      )
     * )
     */
    public function changeStatus($id, $status): JsonResponse
    {
        $model = OperatingStatus::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/operating-status/active-records",
     *     summary="Listado de estatus de operacion",
     *     description="Devuelve un listado de estatus de operacion activos (status_id = 1).",
     *     tags={"Estatus de Operación"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de estatus de operacion activas",
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
    public function activeRecords() : JsonResponse
    {
        $collection = OperatingStatus::where('status_id', 1)->orderBy('name', 'asc')->get(['id', 'name']);
        return response()->json($collection);
    }
}
