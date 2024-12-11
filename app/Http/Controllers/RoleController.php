<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository){}

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Obtener lista de roles",
     *     description="Devuelve una lista paginada de roles",
     *     operationId="getRoles",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for filtering roles",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="role_description", type="string", example="Administrador"),
     *                     @OA\Property(property="name", type="string", example="Administrador"),
     *                     @OA\Property(property="guard_name", type="string", example="web"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true, example=null)
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/api/roles?page=1"),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=1),
     *             @OA\Property(property="last_page_url", type="string", example="http://127.0.0.1:8000/api/roles?page=1"),
     *             @OA\Property(property="links", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="url", type="string", nullable=true, example=null),
     *                     @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                     @OA\Property(property="active", type="boolean", example=false)
     *                 )
     *             ),
     *             @OA\Property(property="next_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="path", type="string", example="http://127.0.0.1:8000/api/roles"),
     *             @OA\Property(property="per_page", type="integer", example=15),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="to", type="integer", example=5),
     *             @OA\Property(property="total", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=500, description="Server Error")
     * )
     */
    public function index(Request $request)
    {
        return $this->repository->searchAndPaginate($request);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Crear un nuevo rol",
     *     tags={"Roles"},
     *     description="Crea un nuevo rol en el sistema.",
     *     operationId="storeRole",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "guard_name"},
     *             @OA\Property(property="name", type="string", example="Prueba 1 nombre del role"),
     *             @OA\Property(property="role_description", type="string", example="Prueba 1 descripcion de role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=6),
     *             @OA\Property(property="name", type="string", example="Prueba 1 nombre del role"),
     *             @OA\Property(property="role_description", type="string", example="Prueba 1 descripcion de role"),
     *             @OA\Property(property="guard_name", type="string", example="api"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-28T22:19:39.469000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-28T22:19:39.469000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="Nombre es obligatorio.")
     *                 ),
     *                 @OA\Property(
     *                     property="role_description",
     *                     type="array",
     *                     @OA\Items(type="string", example="Descripción del role no puede tener más de 50 caracteres.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();
        $data['guard_name'] = 'api';        
        $role = Role::create($data);
        return response()->json($role, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Actualizar un role existente",
     *     description="Actualiza los detalles de un role en función del ID proporcionado.",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del role a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="role_description", type="string", maxLength=50, example="Prueba 1 descripcion de role actualizado"),
     *             @OA\Property(property="name", type="string", maxLength=255, example="Prueba 1 nombre del role actualizado tambien")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role actualizado correctamente",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Role actualizado correctamente"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Nombre es obligatorio."))
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->validated();
        $role->update($data);
        return response()->json("Role actualizado correctamente",201);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/get-roles",
     *     summary="Obtener una lista de roles",
     *     description="Devuelve una lista de roles ordenados por nombre en orden ascendente.",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Administrador"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 )
     *             ),
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Supervisor"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=2
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor"
     *     )
     * )
     */
    public function getRoles(){
        $data = Role::OrderBy('name', 'asc')->select('name', 'id')->get();
        return response()->json($data);
    }
}
