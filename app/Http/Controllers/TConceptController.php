<?php

namespace App\Http\Controllers;

use App\Models\TConcept;
use App\Http\Requests\StoreTConceptRequest;
use App\Http\Requests\UpdateTConceptRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TConceptController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/tconcepts",
     *     summary="Listado paginado de Conceptos-T",
     *     tags={"Conceptos-T"},
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
     *             example="Nombre del concepto"
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
     *         description="Listado de Conceptos-T",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nombre del concepto"),
     *                 @OA\Property(property="status_id", type="integer", example=1),
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
     *     path="/api/tconcepts/active-records",
     *     summary="Lista de Conceptos-T activos",
     *     tags={"Conceptos-T"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de Conceptos-T activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="1", type="string", example="Revalidación"),
     *             @OA\Property(property="2", type="string", example="Inscripción"),
     *             @OA\Property(property="3", type="string", example="Actualización"),
     *             @OA\Property(property="4", type="string", example="Consulta"),
     *             @OA\Property(property="5", type="string", example="Cancelación")
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
        $activeUsers = TConcept::where('status_id', 1)->pluck('name','id');
        return response()->json($activeUsers);
    }

    /**
     * @OA\Post(
     *     path="/api/tconcepts",
     *     summary="Crear un nuevo Concepto-T",
     *     description="Crea un nuevo registro de Concepto-T con los campos proporcionados.",
     *     tags={"Conceptos-T"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Vane castillo"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Concepto-T creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Vane castillo"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z")
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="El nombre del Concepto-T es requerido.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="El estado del Concepto-T es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreTConceptRequest $request)
    {
        $model = TConcept::create([
            'name' => $request->input('name'),
            'status_id' => $request->input('status_id'),
            'user_id' => Auth::id(),
        ]);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/tconcepts/{id}",
     *     summary="Actualizar un Concepto-T existente",
     *     description="Actualiza un registro de Concepto-T con los campos proporcionados.",
     *     tags={"Conceptos-T"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del Concepto-T a actualizar",
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
     *             @OA\Property(property="name", type="string", example="Vane castillo actualizado"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Concepto-T actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Vane castillo actualizado"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z")
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
     *         description="Concepto-T no encontrado",
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="El nombre del Concepto-T es requerido.")),
     *                 @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="El estado del Concepto-T es requerido."))
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateTConceptRequest $request, int $id)
    {
        $model = TConcept::findOrFail($id);
        $model->name = $request->get('name');
        $model->status_id = $request->get('status_id');
        $model->user_id = Auth::id();
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Patch(
     *     path="/api/tconcepts/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Actualiza el estado de un Concepto-T.",
     *     tags={"Conceptos-T"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del Concepto-T a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         description="Nuevo estado del Concepto-T",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Concepto-T actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nombre del Concepto-T"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z")
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
        $model = TConcept::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
}
