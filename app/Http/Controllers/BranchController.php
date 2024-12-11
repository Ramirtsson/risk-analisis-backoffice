<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/branches/active-records",
     *     summary="Obtener listado de sucursales activas",
     *     description="Devuelve un listado de sucursales activas (status_id = 1).",
     *     tags={"Sucursales"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de sucursales activas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="status_id", type="string"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
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
        $data = Branch::where('status_id', 1)->OrderBy('name', 'asc')->pluck('name', 'id');;
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/branches",
     *     summary="Listado de sucursales paginadas y ordenadas de forma ascendente por id de registro.",
     *     tags={"Sucursales"},
     *     @OA\SecurityScheme(
     *         type="http",
     *         description="Bearer Token",
     *         name="Authorization",
     *         in="header",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         securityScheme="bearerAuth",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de sucursales",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Marketing"),
     *                 @OA\Property(property="status", type="string", example="Activo")
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
     *     path="/api/branches",
     *     summary="Crear un nuevo registro de Sucursales",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Sucursales"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string", example="Desarrollo"),
     *             @OA\Property(property="status", type="string", example="A"),
     *             @OA\Property(property="address", type="string", example="calle 2 lote 7"),
     *             @OA\Property(property="user_id", type="integer", example= 1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Creación de registro sucursal correcto",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sucursal creada exitosamente."),
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="status", type="STRING"),
     *                 @OA\Property(property="address", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     * @OA\Response(
     *     response=201,
     *     description="Registration successfully Created"),
     * @OA\Response(
     *     response=404,
     *     description="not found")
     *
     *     ),
     * )
     */
    public function store(StoreBranchRequest $request): JsonResponse
    {
        $query = Branch::create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'status_id' => $request->get('status_id'),
            'user_id' => Auth::id(),
        ]);
        return response()->json($query);
    }

    /**
     * @OA\Put(
     *     path="/api/branches/{id}",
     *     summary="Actualizar registro de sucursales",
     *     description="Actualiza la información especifica de un registro de una sucursal existente.",
     *     tags={"Sucursales"},
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
     *             @OA\Property(property="name", type="string", example="Contabalidad2"),
     *             @OA\Property(property="status_id", type="string", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos"
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="Credenciales incorrectas",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized")
     *           )
     *       )
     * )
     */
    public function update(UpdateBranchRequest $request, $id): JsonResponse
    {
        $model = Branch::findOrFail($id);
        $model->name = $request->get('name');
        $model->address = $request->get('address');
        $model->status_id = $request->get('status_id');
        $model->user_id = Auth::id();
        $model->save();

        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/branches/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Sucursales"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="address", type="string"),
     *                     @OA\Property(property="status_id", type="integer"),
     *                     @OA\Property(property="user_id", type="integer"),
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
        $model = Branch::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
}
