<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFractionRequest;
use App\Models\Fraction;
use App\Http\Requests\StoreFractionRequest;
use App\Http\Requests\UpdateFractionRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Services\Imports\ImportFraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FractionController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository, protected ImportFraction $service)
    {}
    
    /**
     * @OA\Get(
     *     path="/api/fractions",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Fracciones Arancelarias"},
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
     *             example="MEDICAL"
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
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="level_product_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *                  @OA\Property(property="level_product", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Prohibido"),
     *                         @OA\Property(property="status_id", type="string", example="1"),
     *                         @OA\Property(property="user_id", type="string", example="1"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 ),
     *                  @OA\Property(property="detail_fraction", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Prohibido"),
     *                         @OA\Property(property="fraction_id", type="string", example="1"),
     *                         @OA\Property(property="user_id", type="string", example="1"),
     *                         @OA\Property(property="status_id", type="string", example="1"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
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
     *     path="/api/fractions",
     *     summary="Crear un nuevo registro de Fraccion Arancelaria",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Fracciones Arancelarias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description","status_id","level_products_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="description", type="string", example="descripcion"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="level_product_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="description", type="string", example="descripcion"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="level_products_id", type="string", example="1"),
     *             @OA\Property(property="user_id", type="string", example="1"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */
    public function store(StoreFractionRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = Fraction::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/fractions/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Fraccion Arancelaria existente.",
     *     tags={"Fracciones Arancelarias"},
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
     *             required={"name", "description","status_id","level_products_id"},
     *             @OA\Property(property="name", type="string", example="name edit"),
     *             @OA\Property(property="description", type="string", example="descripcion edit"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="level_product_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fraccion arancelaria actualizada correctamente",
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

    public function update(UpdateFractionRequest $request, Fraction $fraction)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $fraction->update($data);
        return response()->json("Fraccion arancelaria actualizada correctamente");
    }

    /**
     * @OA\Patch(
     *     path="/api/fractions/{id}/status/{status}",
     *     summary="Marcar un registro de Fraccion Arancelaria como inactivo o activo.",
     *     description="Actualiza el estado de una Fraccion Arancelaria a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Fracciones Arancelarias"},
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
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="level_product_id", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *                  @OA\Property(property="levelProduct", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Prohibido"),
     *                         @OA\Property(property="status_id", type="string", example="1"),
     *                         @OA\Property(property="user_id", type="string", example="1"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 ),
     *                  @OA\Property(property="detail_fraction", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Prohibido"),
     *                         @OA\Property(property="fraction_id", type="string", example="1"),
     *                         @OA\Property(property="user_id", type="string", example="1"),
     *                         @OA\Property(property="status_id", type="string", example="1"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 ),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object"),
     *         ),
     * 
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fraccion Arancelaria no encontrado."
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
        $model = Fraction::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/fractions/active-records",
     *     summary="Listado de Fracciones Arancelarias con estatus activo",
     *     description="Devuelve un listado de Fracciones Arancelarias con estatus activo.",
     *     tags={"Fracciones Arancelarias"},
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
     *                     @OA\Property(property="levelProduct", type="string"),
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
        $collection = Fraction::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }
    /**
     * @OA\Post(
     *     path="/api/fractions/import",
     *     summary="Crear varios registros de fracciones Arancelarias",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Fracciones Arancelarias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="fractions", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="name", type="string", example="9879899"),
     *                     @OA\Property(property="description", type="string", example="description"),
     *                     @OA\Property(property="level_product_id", type="string", example="1"),
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
    public function importFractions(ImportFractionRequest $request): JsonResponse
    {
        $collection = $this->service->importFile($request);
        return response()->json($collection,201);
    }
}
