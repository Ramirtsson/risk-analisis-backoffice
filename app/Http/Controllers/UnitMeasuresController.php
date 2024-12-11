<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitMeasuresRequest;
use App\Http\Requests\UpdateUnitMeasuresRequest;
use App\Models\UnitMeasure;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitMeasuresController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository){}

    /**
     * @OA\Get(
     *     path="/api/unit-measures",
     *     summary="Listado paginado de Unidades de medida",
     *     tags={"Unidades de medida"},
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
     *         description="Buscar por unidad de medida, código, prefijo o estado",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example=""
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
     *         description="Listado de Unidades de medida",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Megas"),
     *                 @OA\Property(property="code", type="char", example="24"),
     *                 @OA\Property(property="prefix", type="char", example="MG"),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Activo")
     *                 )
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
     *     path="/api/unit-measures/active-records",
     *     summary="Lista de Unidades de medida",
     *     tags={"Unidades de medida"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de Unidades de medida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="1", type="string", example="GRAMO"),
     *             @OA\Property(property="2", type="string", example="METRO LINEAL"),
     *             @OA\Property(property="3", type="string", example="Kilogramo"),
     *             @OA\Property(property="4", type="string", example="METRO CÚBICO"),
     *             @OA\Property(property="5", type="string", example="PAR")
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
        $activeUsers = UnitMeasure::where('status_id', 1)->pluck('name','id');
        return response()->json($activeUsers);
    }

    /**
     * @OA\Post(
     *     path="/api/unit-measures",
     *     summary="Crear una nueva Unidad de medida",
     *     description="Crea un nuevo registro de Unidad de medida con los campos proporcionados.",
     *     tags={"Unidades de medida"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Cuarks"),
     *             @OA\Property(property="code", type="char", example="27"),
     *             @OA\Property(property="prefix", type="char", example="QK"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidad de medida creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Cuarks"),
     *                 @OA\Property(property="code", type="char", example="27"),
     *                 @OA\Property(property="prefix", type="char", example="QK"),
     *                 @OA\Property(property="status_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Activo")
     *                 )
     *             )
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Campo unidad de medida es obligatorio.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado de la unidad de medida es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreUnitMeasuresRequest $request): JsonResponse
    {
        $model = UnitMeasure::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'prefix' => $request->input('prefix'),
            'status_id' => $request->input('status_id'),
            'user_id' => Auth::id(),
        ]);

        return response()->json($model, 201);
    }

     /**
     * @OA\Put(
     *     path="/api/unit-measures/{id}",
     *     summary="Editar una nueva Unidad de medida",
     *     description="Editar un nuevo registro de Unidad de medida con los campos proporcionados.",
     *     tags={"Unidades de medida"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del Unidades de medida para actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Cuarks Actualizado"),
     *             @OA\Property(property="code", type="char", example="27"),
     *             @OA\Property(property="prefix", type="char", example="QK"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidad de medida creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Cuarks Actualizado"),
     *                 @OA\Property(property="code", type="char", example="27"),
     *                 @OA\Property(property="prefix", type="char", example="QK"),
     *                 @OA\Property(property="status_id", type="integer", example=2),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="Inactivo")
     *                 )
     *             )
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
     *         description="Unidad de medida no encontrado",
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Campo unidad de medida es obligatorio.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado de la unidad de medida es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateUnitMeasuresRequest $request, int $id):JsonResponse
    {
        $model = UnitMeasure::findOrFail($id);
        $model->name = $request->get('name');
        $model->code = $request->get('code');
        $model->prefix = $request->get('prefix');
        $model->status_id = $request->get('status_id');
        $model->user_id = Auth::id();
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Patch(
     *     path="/api/unit-measures/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Actualiza el estado de Unidad de medida.",
     *     tags={"Unidades de medida"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del Unidad de medida para actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         description="Nuevo estado de la Unidad de medida",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidad de medida creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Cuarks Actualizado"),
     *                 @OA\Property(property="code", type="char", example="27"),
     *                 @OA\Property(property="prefix", type="char", example="QK"),
     *                 @OA\Property(property="status_id", type="integer", example=2),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="Inactivo")
     *                 )
     *             )
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
     *         description="Concepto-T no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Not Found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function changeStatus($id, $status): JsonResponse
    {
        $model = UnitMeasure::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

}
