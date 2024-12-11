<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportDetailFractionRequest;
use App\Models\DetailFraction;
use App\Http\Requests\StoreDetailFractionRequest;
use App\Http\Requests\UpdateDetailFractionRequest;
use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Services\Imports\ImportDetailFraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailFractionController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository, protected ImportDetailFraction $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/detail-fractions",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Detalle de fracciones arancelarias"},
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
     *             example="figuritas de animales"
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
     *                 @OA\Property(property="fraction_id", type="string"),
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
     *     path="/api/detail-fractions",
     *     summary="Crear un nuevo registro de detalle de fraccion arancelaria",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Detalle de fracciones arancelarias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "fraction_id","status_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="fraction_id", type="string", example="1"),
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
     *             @OA\Property(property="fraction_id", type="string", example="1"),
     *             @OA\Property(property="user_id", type="string", example="1"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
     */
    public function store(StoreDetailFractionRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = DetailFraction::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/detail-fractions/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza detalle de fraccion arancelaria existente.",
     *     tags={"Detalle de fracciones arancelarias"},
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
     *             required={"name","fraction_id","status_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="fraction_id", type="string", example="1"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalle de Fraccion Arancelaria actualizada correctamente",
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

    public function update(UpdateDetailFractionRequest $request, DetailFraction $detailFraction)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $detailFraction->update($data);
        return response()->json("Detalle de fraccion arancelaria actualizado correctamente");
    }

    /**
     * @OA\Patch(
     *     path="/api/detail-fractions/{id}/status/{status}",
     *     summary="Marcar un registro de detalle de fraccion arancelaria como inactivo o activo.",
     *     description="Actualiza el estado de una detalle de fraccion arancelaria a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Detalle de fracciones arancelarias"},
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
     *                 @OA\Property(property="fraction_id", type="string"),
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
     *         description="detalle de fraccion arancelaria no encontrado."
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
        $model = DetailFraction::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/detail-fractions/active-records",
     *     summary="Listado de detalle de fraccion arancelaria con estatus activo",
     *     description="Devuelve un listado de detalle de fraccion arancelaria con estatus activo.",
     *     tags={"Detalle de fracciones arancelarias"},
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
        $collection = DetailFraction::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }

    /**
     * @OA\Patch(
     *     path="/api/detail-fractions/{id}",
     *     summary="Listado detalle de fracciones filtrado por fraction.",
     *     description="Retorna listado filtrado por Id de fracción",
     *     tags={"Detalle de fracciones arancelarias"},
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
     *                 @OA\Property(property="fraction_id", type="integer"),
     *                 @OA\Property(property="status_id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *                 @OA\Property(property="fraction", type="object",
     *                          @OA\Property(property="id", type="integer", example="1"),
     *                          @OA\Property(property="name", type="string", example="---"),
     *                          @OA\Property(property="description", type="string", example="---"),
     *                          @OA\Property(property="status_id", type="integer"),
     *                          @OA\Property(property="status", type="object",
     *                          @OA\Property(property="id", type="string", example="1"),
     *                          @OA\Property(property="name", type="string", example="Activo"),
     *                          ),
     *                  ),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object"),
     *         ),
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="---"
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
    public function show(Request $request, $id): JsonResponse
    {
        $collection = $this->repository->showDetailFractions($request, $id);

        return response()->json($collection);
    }
    /**
     * @OA\Post(
     *     path="/api/detail-fractions/import",
     *     summary="Crear varios registros de detalle de fraccion arancelaria",
     *     description="Crea una nuevo registro en base de datos. (el name debe ser la fraccion a la cual se agregará)",
     *     tags={"Detalle de fracciones arancelarias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="detailFractions", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="name", description="Escribir fraccion", type="string", example="12345681"),
     *                     @OA\Property(property="description", type="string", example="description"),
     *                     @OA\Property(property="status_id", type="string", example="1")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Todos los elementos fueron registrados correctamente."
     *         )
     *     ),
     * )
     */
    public function importDetailFractions(ImportDetailFractionRequest $request) :JsonResponse
    {
       $collection = $this->service->importFile($request);
       return response()->json($collection,201);
    }
}
