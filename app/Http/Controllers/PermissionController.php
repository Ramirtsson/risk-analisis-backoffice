<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Repositories\Contracts\ISearchAndPaginate;

class PermissionController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository){}
    
    /**
     * @OA\Get(
     *     path="/api/permissions",
     *     summary="Obtener lista de permisos paginada con búsqueda",
     *     description="Retorna una lista paginada de permisos con soporte para búsqueda en los campos 'name' y 'guard_name'.",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de la página",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Término de búsqueda para filtrar permisos por 'name' o 'guard_name'",
     *         required=false,
     *         @OA\Schema(type="string", example="admin")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos paginada con búsqueda",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Permiso de prueba"),
     *                     @OA\Property(property="guard_name", type="string", example="api"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-29T22:19:18.920000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-29T22:26:18.820000Z")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/api/permissions?page=1"),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=1),
     *             @OA\Property(property="last_page_url", type="string", example="http://127.0.0.1:8000/api/permissions?page=1"),
     *             @OA\Property(property="links", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="url", type="string", nullable=true, example="http://127.0.0.1:8000/api/permissions?page=1"),
     *                     @OA\Property(property="label", type="string", example="1"),
     *                     @OA\Property(property="active", type="boolean", example=true)
     *                 )
     *             ),
     *             @OA\Property(property="next_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="path", type="string", example="http://127.0.0.1:8000/api/permissions"),
     *             @OA\Property(property="per_page", type="integer", example=15),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="to", type="integer", example=2),
     *             @OA\Property(property="total", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta"
     *     )
     * )
     */
    public function index(Request $request)
    {
        return $this->repository->searchAndPaginate($request);
    }

    /**
     * @OA\Post(
     *     path="/api/permissions",
     *     summary="Crear un nuevo permiso",
     *     description="Crea un nuevo permiso en el sistema con los datos proporcionados.",
     *     tags={"Permisos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Prueba 2 nombre del permiso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Permiso creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="api"),
     *             @OA\Property(property="guard_name", type="string", example="web"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-29T22:19:18.919000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-29T22:19:18.919000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array", 
     *                     @OA\Items(type="string", example="Nombre es obligatorio.")
     *                 ),
     *                 @OA\Property(property="guard_name", type="array", 
     *                     @OA\Items(type="string", example="Nombre del guardia es obligatorio.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StorePermissionRequest $request)
    {
        $data = $request->validated();
        $data['guard_name'] = 'api';        
        $permission = Permission::create($data);
        return response()->json($permission, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/permissions/{id}",
     *     summary="Actualizar un permiso existente",
     *     description="Actualiza los datos de un permiso existente usando su ID.",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del permiso a actualizar",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Prueba 2 nombre del permiso actualizado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Permiso actualizado correctamente",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Permiso actualizado correctamente"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array", 
     *                     @OA\Items(type="string", example="Nombre es obligatorio.")
     *                 ),
     *                 @OA\Property(property="guard_name", type="array", 
     *                     @OA\Items(type="string", example="Nombre del guardia es obligatorio.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Permiso no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Permiso no encontrado")
     *         )
     *     )
     * )
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $data = $request->validated();
        $permission->update($data);
        return response()->json("Permiso actualizado correctamente",201);
    }

    /**
     * @OA\Get(
     *     path="/api/permissions/get-permissions",
     *     summary="Obtener una lista de permisos",
     *     description="Devuelve una lista de permisos ordenados por nombre en orden ascendente.",
     *     tags={"Permisos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Permiso1"
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
     *                     example="Permiso 2"
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
    public function getPermissions(){
        $data = Permission::OrderBy('name', 'asc')->select('name', 'id')->get();
        return response()->json($data);
    }
}
