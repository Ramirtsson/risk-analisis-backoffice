<?php

namespace App\Http\Controllers;

use App\Models\SystemModule;
use App\Http\Requests\StoreSystemModuleRequest;
use App\Http\Requests\UpdateSystemModuleRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SystemModuleController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/modules",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Modulos de acceso"},
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
     *             example="Ventas"
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
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example=""),
     *                 @OA\Property(property="status", type="string", example="A"),
     *                 @OA\Property(property="user_id", type="string", example="1")
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
     *     path="/api/modules",
     *     summary="Crear un nuevo registro",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Modulos de acceso"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "status", "user_id"},
     *             @OA\Property(property="name", type="string", example="Desarrollo"),
     *             @OA\Property(property="status_id", type="string", example="--"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="status_id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     * @OA\Response(
     *           response=401,
     *           description="Credenciales incorrectas",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized")
     *           )
     *       )
     * )
     */
    public function store(StoreSystemModuleRequest $request): JsonResponse
    {
        $model = SystemModule::create([
            'name' => $request->input('name'),
            'status_id' => $request->input('status_id'),
            'user_id' => Auth::id(),
        ]);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/modules/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza la información especifica de un registro existente.",
     *     tags={"Modulos de acceso"},
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
     *             @OA\Property(property="status_id", type="string", example="--"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valor booleano 1 o 0",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos"
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="Credenciales incorrectas",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized")
     *           )
     *       )
     * )
     */
    public function update($id, UpdateSystemModuleRequest $request): JsonResponse
    {
        $model = SystemModule::findOrFail($id);
        $model->name = $request->get('name');
        $model->status_id = $request->get('status_id');
        $model->user_id = Auth::id();
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/modules/active-records",
     *     summary="Listado de modulos de acceso estatus activo",
     *     description="Devuelve un listado de modulos de acceso con estatus activo.",
     *     tags={"Modulos de accesso"},
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
        $collection = SystemModule::where('status', 'A')->pluck('name', 'id');
        return response()->json($collection);
    }

    /**
     * @OA\Get(
     *     path="/api/modules/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Modulos de accesso"},
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
        $model = SystemModule::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
}
