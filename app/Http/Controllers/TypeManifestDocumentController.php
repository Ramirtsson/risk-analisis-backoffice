<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFileDocumentManifest;
use App\Models\TypeManifestDocument;
use App\Http\Requests\StoreTypeManifestDocumentRequest;
use App\Http\Requests\UpdateTypeManifestDocumentRequest;
use App\Models\Manifest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeManifestDocumentController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/types-manifests-documents",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Tipo de documento de manifiesto"},
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
     *             example=" "
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
    public function show($id): JsonResponse
    {
        $model = TypeManifestDocument::with(['documentManifests' => function ($query) use ($id) {
            $query->where("manifest_id", $id);
        }])->get();
        return response()->json($model);
    }
    /**
     * @OA\Post(
     *     path="/api/types-manifests-documents",
     *     summary="Crear un nuevo registro de Tipo de documento",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Tipo de documento de manifiesto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","status_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="user_id", type="string", example="1"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
     */
    public function store(StoreTypeManifestDocumentRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = TypeManifestDocument::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/types-manifests-documents/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza el tipo de documento existente.",
     *     tags={"Tipo de documento de manifiesto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Trafico de ejemplo editado"),
     *              @OA\Property(property="status_id", type="string", example="1")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Tráfico actualizado exitosamente",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Trafico de ejemplo editado"),
     *              @OA\Property(property="status_id", type="string", example="1"),
     *              @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T00:00:00Z"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T00:00:00Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Solicitud incorrecta",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Bad Request")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Credenciales incorrectas",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tráfico no encontrado",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Not Found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Datos de validación incorrectos",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Unprocessable Entity"),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="name", type="array", @OA\Items(type="string", example="Nombre del tráfico es requerido.")),
     *                  @OA\Property(property="status_id", type="array", @OA\Items(type="string", example="Estado del tráfico es requerido."))
     *              )
     *          )
     *      )
     * )
     */

    public function update(UpdateTypeManifestDocumentRequest $request, TypeManifestDocument $types_manifests_document)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $types_manifests_document->update($data);
        return response()->json("Tipo de documento actualizado correctamente");
    }

    /**
     * @OA\Patch(
     *     path="/api/types-manifests-documents/{id}/status/{status}",
     *     summary="Marcar un registro de tipo de documento como inactivo o activo.",
     *     description="Actualiza el estado de una Proveedor a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Tipo de documento de manifiesto"},
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
     *                 @OA\Property(property="status_id", type="string"),
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
     *         description="Tipo de docmento no encontrado."
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
        $model = TypeManifestDocument::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/types-manifests-documents/active-records",
     *     summary="Listado de Tipo de documento con estatus activo",
     *     description="Devuelve un listado de Provedores con estatus activo.",
     *     tags={"Tipo de documento de manifiesto"},
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
        $collection = TypeManifestDocument::where('status_id', 1)->get(['name', 'id']);
        return response()->json($collection);
    }
}
