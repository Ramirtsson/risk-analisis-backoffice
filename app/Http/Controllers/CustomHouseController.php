<?php

namespace App\Http\Controllers;

use App\Models\CustomHouse;
use App\Http\Requests\StoreCustomHouseRequest;
use App\Http\Requests\UpdateCustomHouseRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomHouseController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    
    /**
     * @OA\Get(
     *     path="/api/customs-house",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Aduanas"},
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
     *             example="AEROPUERTO INTERNACIONAL FELIPE ÁNGELES, SANTA LUCÍA, ZUMPANGO, ESTADO DE MÉXICO"
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
     *                 @OA\Property(property="code", type="string"),
     *                 @OA\Property(property="status_id", type="string"),
     *                 @OA\Property(property="user_id", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="name", type="string", example="Activo"),
     *                 )
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
     *     path="/api/customs-house",
     *     summary="Crear un nuevo registro de Aduanas",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Aduanas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "code","status_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="code", type="string", example="code"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="status_id", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */

    public function store(StoreCustomHouseRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = CustomHouse::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/customs-house/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Aduana existente.",
     *     tags={"Aduanas"},
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
     *             required={"name", "code","status_id"},
     *             @OA\Property(property="name", type="string", example="nameEditado"),
     *             @OA\Property(property="code", type="string", example="1231e"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aduana actualizada correctamente",
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

     public function update(UpdateCustomHouseRequest $request, CustomHouse $customs_house)
     {
         $data = $request->validated();
         $data["user_id"] = Auth::id();
         $customs_house->update($data);
         return response()->json("Aduanas actualizado correctamente",201);
     }

         /**
     * @OA\Patch(
     *     path="/api/customs-house/{id}/status/{status}",
     *     summary="Marcar un registro de Aduanas como inactivo o activo.",
     *     description="Actualiza el estado de una Aduanas a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Aduanas"},
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
     *                 @OA\Property(property="code", type="string"),
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
     *         description="Aduanas no encontrado."
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
        $model = CustomHouse::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/customs-house/active-records",
     *     summary="Listado de Aduanas con estatus activo",
     *     description="Devuelve un listado de Aduanas con estatus activo.",
     *     tags={"Aduanas"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="code", type="string"),
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
        $collection = CustomHouse::where('status_id', 1)->select('name', 'code','id')->get();
        return response()->json($collection);
    }

    
    public function show(Request $request,$id): JsonResponse
    {
        $collection = $this->repository->searchAndPaginateActives($request,$id);
        return response()->json($collection);
    }
}
