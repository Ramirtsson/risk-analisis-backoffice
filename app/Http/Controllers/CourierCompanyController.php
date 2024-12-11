<?php

namespace App\Http\Controllers;

use App\Models\CourierCompany;
use App\Http\Requests\StoreCourierCompanyRequest;
use App\Http\Requests\UpdateCourierCompanyRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierCompanyController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    
    /**
     * @OA\Get(
     *     path="/api/courier-companies",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Empresa de Mensajeria"},
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
     *             example="CONTROL Y COMERCIO VALEM SAPI DE CV."
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
     *                 @OA\Property(property="social_reason", type="string"),
     *                 @OA\Property(property="tax_domicile", type="string"),
     *                 @OA\Property(property="tax_id", type="string"),
     *                 @OA\Property(property="validity", type="string"),
     *                 @OA\Property(property="registration", type="string"),
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
     *     path="/api/courier-companies",
     *     summary="Crear un nuevo registro de Empresa de Mensajeria",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Empresa de Mensajeria"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"social_reason", "tax_domicile","tax_id","validity","registration","status","user_id"},
     *             @OA\Property(property="social_reason", type="string", example="razon social"),
     *             @OA\Property(property="tax_domicile", type="string", example="example tax domicile"),
     *             @OA\Property(property="tax_id", type="string", example="123"),
     *             @OA\Property(property="validity", type="string", example="123"),
     *             @OA\Property(property="registration", type="string", example="123"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="social_reason", type="string"),
     *             @OA\Property(property="tax_domicile", type="string"),
     *             @OA\Property(property="tax_id", type="string"),
     *             @OA\Property(property="validity", type="string"),
     *             @OA\Property(property="registration", type="string"),
     *             @OA\Property(property="status_id", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="id", type="integer", example=1),
     *             )
     *         )
     *     ),
     * )
    */

    public function store(StoreCourierCompanyRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = CourierCompany::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/courier-companies/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Empresa de Mensajeria existente.",
     *     tags={"Empresa de Mensajeria"},
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
     *             required={"social_reason", "tax_domicile", "tax_id", "validity", "registration", "status", "user_id"},
     *             @OA\Property(property="social_reason", type="string", example="razon social"),
     *             @OA\Property(property="tax_domicile", type="string", example="tax domicile"),
     *             @OA\Property(property="tax_id", type="string", example="tax123"),
     *             @OA\Property(property="validity", type="string", example="1412"),
     *             @OA\Property(property="registration", type="string", example="1ss"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa de Mensajeria actualizada correctamente",
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

    public function update(UpdateCourierCompanyRequest $request, CourierCompany $courierCompany)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = $courierCompany->update($data);
        return response()->json("Empresa de Mensajeria actualizada correctamente");
    }

        /**
     * @OA\Patch(
     *     path="/api/courier-companies/{id}/status/{status}",
     *     summary="Marcar un registro de Empresa de Mensajeria como inactivo o activo.",
     *     description="Actualiza el estado de una empresa de mensajeria a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Empresa de Mensajeria"},
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
     *                 @OA\Property(property="social_reason", type="string"),
     *                 @OA\Property(property="tax_domicile", type="string"),
     *                 @OA\Property(property="tax_id", type="string"),
     *                 @OA\Property(property="validity", type="string"),
     *                 @OA\Property(property="registration", type="string"),
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
        $model = CourierCompany::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        $model->refresh();
        return response()->json($model);
    }
    /**
     * @OA\Get(
     *     path="/api/courier-companies/active-records",
     *     summary="Listado de Empresas de Mensajeria con estatus activo",
     *     description="Devuelve un listado de Empresas de Mensajeria con estatus activo.",
     *     tags={"Empresa de Mensajeria"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="social_reason", type="string"),
     *                     @OA\Property(property="registration", type="string"),
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
    public function activeRecords(): JsonResponse
    {
        $collection = CourierCompany::where('status_id', 1)->get(['id', 'social_reason', 'registration']);
        return response()->json($collection);
    }
}
