<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationConceptRequest;
use App\Http\Requests\UpdateApplicationConceptRequest;
use App\Models\ApplicationConcept;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\ISearchAndPaginate;


class ApplicationConceptController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    /**
     * @OA\Get(
     *     path="/api/application-concepts/active-records",
     *     summary="Obtener registros activos de Conceptos",
     *     description="Devuelve un listado de Conceptos activos (status_id = '1').",
     *     tags={"Conceptos"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de conceptos de aplicación activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron registros en la base de datos."
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
    public function activeRecords(): JsonResponse
    {
        $data = ApplicationConcept::where('status_id', '1')->OrderBy('name', 'asc')->pluck('name','id');
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/application-concepts",
     *     summary="Obtener una lista paginada de Conceptos",
     *     description="Devuelve un listado paginado de Conceptos, ordenados de forma descendente por id.",
     *     tags={"Conceptos"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Término de búsqueda para filtrar resultados",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Cantidad de registros por página",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="current_page",
     *         in="query",
     *         description="Número de la página actual",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de Conceptos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Concepto Ejemplo"),
     *                 @OA\Property(property="status_id", type="string", example="1"),
     *                 @OA\Property(property="user_id", type="string", example="1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
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
     * @OA\Post(
     *     path="/api/application-concepts",
     *     summary="Crear un nuevo registro de Conceptos",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Conceptos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "status_id"},
     *             @OA\Property(property="name", type="string", example="razon social"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status_id", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */
    public function store(StoreApplicationConceptRequest $request): JsonResponse
    {
        $data=$request->validated();
        $data["user_id"]=Auth::id();
        $query = ApplicationConcept::create($data);
        return response()->json($query, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/application-concepts/{id}",
     *     summary="Actualizar un Concepto",
     *     description="Actualiza un Concepto.",
     *     tags={"Conceptos"},
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
     *             @OA\Property(property="name", type="string", example="Concepto Actualizado"),
     *             @OA\Property(property="status_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Concepto actualizado correctamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Concepto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos"
     *     )
     * )
     */
    public function update(UpdateApplicationConceptRequest $request, $id): JsonResponse
    {
        $data= $request->all();
        $data['user_id']=Auth::id();
        $model = ApplicationConcept::where('id', $id)->update($data);
        return response()->json("Concepto actualizado correctamente", 200);
    }
    /**
     * @OA\Patch(
     *     path="/api/application-concepts/{id}/status/{status}",
     *     summary="Marcar un registro de Conceptos como inactivo o activo.",
     *     description="Actualiza el estado de un concepto a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Conceptos"},
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
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="tax_domicile", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *             ),
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
        $model = ApplicationConcept::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
}
