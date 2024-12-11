<?php

namespace App\Http\Controllers;

use App\Models\Traficc;
use App\Http\Requests\StoreTraficcRequest;
use App\Http\Requests\UpdateTraficcRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TraficcController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/traficcs",
     *     summary="Listado paginado de tráficos",
     *     tags={"Tráficos"},
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
     *             example="Nombre del tráfico"
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
     *                 @OA\Property(property="name", type="string", example="Nombre del tráfico"),
     *                 @OA\Property(property="status_id", type="integer", example="1"),
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
     *     path="/api/traficcs/active-records",
     *     summary="Lista de tráficos activos",
     *     tags={"Tráficos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tráficos activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nombre del tráfico")
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
    public function activeRecords(): JsonResponse
    {
        $activeUsers = Traficc::where('status_id', 1)->pluck('name','id');
        return response()->json($activeUsers);
    }

    /**
     * @OA\Post(
     *     path="/api/traficcs",
     *     summary="Crear un nuevo tráfico",
     *     description="Crea un nuevo registro de tráfico con los campos proporcionados.",
     *     tags={"Tráficos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Trafico de ejemplo"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tráfico creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Trafico de ejemplo"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T00:00:00Z")
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Nombre del tráfico es requerido.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado del tráfico es requerido.")),
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreTraficcRequest $request): JsonResponse
    {
        $model = Traficc::create([
            'name' => $request->input('name'),
            'status_id' => $request->input('status_id'),
            'user_id' => Auth::id(),
        ]);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/traficcs/{id}",
     *     summary="Actualizar un tráfico existente",
     *     description="Actualiza un registro de tráfico existente con los campos proporcionados.",
     *     tags={"Tráficos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del tráfico a actualizar"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Trafico de ejemplo editado"),
     *             @OA\Property(property="status", type="string", example="I"),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tráfico actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Trafico de ejemplo editado"),
     *             @OA\Property(property="status_id", type="string", example="I"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T00:00:00Z")
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
     *         description="Tráfico no encontrado",
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Nombre del tráfico es requerido.")),
     *                 @OA\Property(property="status", type="array", @OA\Items(type="string", example="Estado del tráfico es requerido.")),
     *                 @OA\Property(property="user_id", type="array", @OA\Items(type="string", example="ID de usuario es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateTraficcRequest $request, int $id)
    {
        $model = Traficc::findOrFail($id);
        $model->name = $request->get('name');
        $model->status_id = $request->get('status_id');
        $model->user_id = Auth::id();
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/traficcs/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Modulos de trafico"},
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
        $model = Traficc::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

}
