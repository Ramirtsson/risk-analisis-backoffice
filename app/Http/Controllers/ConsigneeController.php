<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreConsigneeRequest;
use App\Http\Requests\UpdateConsigneeRequest;
use App\Models\Consignee;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsigneeController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    /**
     * @OA\Get(
     *     path="/api/consignees",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Consignatarios"},
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
     *             example="KWT INTERNATIONAL TRADING LIMITED"
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
     *                 @OA\Property(property="rfc", type="string"),
     *                 @OA\Property(property="curp", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="phone", type="string"),
     *                 @OA\Property(property="zip_code", type="string"),
     *                 @OA\Property(property="state", type="string"),
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
     *     path="/api/consignees",
     *     summary="Crear un nuevo registro de Consignatario",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Consignatarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","rfc","curp","address","city","email","phone","zip_code","state","status_id","user_id"},
     *                    @OA\Property(property="name", type="string", example=""),
     *                    @OA\Property(property="rfc", type="string",example=""),
     *                    @OA\Property(property="curp", type="string",example=""),
     *                    @OA\Property(property="address", type="string",example=""),
     *                    @OA\Property(property="city", type="string",example="t"),
     *                    @OA\Property(property="email", type="string",example=""),
     *                    @OA\Property(property="phone", type="string",example =""),
     *                    @OA\Property(property="zip_code", type="",example =""),
     *                    @OA\Property(property="state", type="string", example= ""),
     *                    @OA\Property(property="user_id", type="integer", example = ""),
     *                    @OA\Property(property="status_id", type="integer",example = "")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *                   @OA\Property(property="rfc", type="string"),
     *                   @OA\Property(property="curp", type="string"),
     *                   @OA\Property(property="address", type="string"),
     *                   @OA\Property(property="city", type="string"),
     *                   @OA\Property(property="email", type="string"),
     *                   @OA\Property(property="phone", type="string"),
     *                   @OA\Property(property="zip_code", type="string"),
     *                   @OA\Property(property="state", type="string"),
     *                   @OA\Property(property="user_id", type="string"),
     *                   @OA\Property(property="status_id", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
     */
    public function store(StoreConsigneeRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = Consignee::create($data);
        return response()->json($model);
    }
    /**
     * @OA\Put(
     *     path="/api/consignees/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Consignatario existente.",
     *     tags={"Consignatarios"},
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
     *            required={"name","rfc","curp","address","city","email","phone","zip_code","state","status_id","user_id"},
     *                   @OA\Property(property="name", type="string", example="Dr. Rick Swift"),
     *                   @OA\Property(property="rfc", type="string",example="AKWALBUUC5UQ2"),
     *                   @OA\Property(property="curp", type="string",example="AQHMHRPEFHPKI"),
     *                   @OA\Property(property="address", type="string",example="1HO27VOZFNMOT"),
     *                   @OA\Property(property="city", type="string",example="Mrazfort"),
     *                   @OA\Property(property="email", type="string",example="jtorphy@example.net"),
     *                   @OA\Property(property="phone", type="string",example ="+19864640937"),
     *                   @OA\Property(property="zip_code", type="string", type="34995-8692"),
     *                   @OA\Property(property="state", type="string", example= "BNLDNS"),
     *                   @OA\Property(property="user_id", type="integer", example = "1"),
     *                   @OA\Property(property="status_id", type="integer",example = "1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consignatario actualizado correctamente",
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

    public function update(UpdateConsigneeRequest $request, Consignee $consignee)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $consignee->update($data);
        return response()->json("Consignatario actualizado correctamente");
    }

    /**
     * @OA\Patch(
     *     path="/api/consignees/{id}/status/{status}",
     *     summary="Marcar un registro de consignatario como inactivo o activo.",
     *     description="Actualiza el estado de una Consignatario a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Consignatarios"},
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
     *                    @OA\Property(property="id", type="string", example="1"),
     *                    @OA\Property(property="name", type="string"),
     *                    @OA\Property(property="rfc", type="string"),
     *                    @OA\Property(property="curp", type="string"),
     *                    @OA\Property(property="address", type="string"),
     *                    @OA\Property(property="city", type="string"),
     *                    @OA\Property(property="email", type="string"),
     *                    @OA\Property(property="phone", type="string"),
     *                    @OA\Property(property="zip_code", type="string"),
     *                    @OA\Property(property="state", type="string"),
     *                    @OA\Property(property="user_id", type="string"),
     *                    @OA\Property(property="status_id", type="string"),
     *                    @OA\Property(property="created_at", type="string", format="date-time"),
     *                    @OA\Property(property="updated_at", type="string", format="date-time"),
     *                    @OA\Property(property="status", type="object",
     *                          @OA\Property(property="id", type="string", example="1"),
     *                          @OA\Property(property="name", type="string", example="Activo"),
     *                 ),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object"),
     *         ),
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Consignatario no encontrado."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function changeStatus($id, $status): JsonResponse
    {
        $model = Consignee::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/Consignees/active-records",
     *     summary="Listado de consignatarios con estatus activo",
     *     description="Devuelve un listado de Consignatarios con estatus activo.",
     *     tags={"Consignatarios"},
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
        $collection = Consignee::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }
}
