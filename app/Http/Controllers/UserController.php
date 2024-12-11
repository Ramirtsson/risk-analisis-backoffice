<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserValidateRequest;
use App\Models\User;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role as RoleModelSpatie;

class UserController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Obtener listado de usuarios paginados y ordenados de forma descendente por id de registro.",
     *     tags={"Usuarios"},
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
     *         description="Buscar por nombre de usuario o estado",
     *         required=false,
     *         @OA\Schema(type="string", example="Marketing")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Número de elementos por página",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="current_page",
     *         in="query",
     *         description="Página actual",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="PRUEBA1"),
     *                     @OA\Property(property="status_id", type="string", example="1"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-08T19:36:53.780000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-08T19:36:53.780000Z"),
     *                     @OA\Property(property="role_id", type="integer", example=1),
     *                     @OA\Property(property="role", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="role_description", type="string", example="Administrador"),
     *                         @OA\Property(property="name", type="string", example="Administrador"),
     *                         @OA\Property(property="guard_name", type="string", example="api"),
     *                         @OA\Property(property="permissions", type="array",
     *                             @OA\Items(type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="Permiso 1"),
     *                                 @OA\Property(property="guard_name", type="string", example="api"),
     *                                 @OA\Property(property="pivot", type="object",
     *                                     @OA\Property(property="model_type", type="string", example="App\Models\User"),
     *                                     @OA\Property(property="model_id", type="integer", example=3),
     *                                     @OA\Property(property="permission_id", type="integer", example=1)
     *                                 )
     *                             )
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Permiso 1"),
     *                     @OA\Property(property="guard_name", type="string", example="api")
     *                 )
     *             ),
     *             @OA\Property(property="status", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Activo")
     *             ),
     *             @OA\Property(property="profile", type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="name", type="string", example="Sergio"),
     *                 @OA\Property(property="last_name", type="string", example="Prueba"),
     *                 @OA\Property(property="second_lastname", type="string", example="1"),
     *                 @OA\Property(property="email", type="string", example="sergio@prueba1.com"),
     *                 @OA\Property(property="branch_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=3),
     *                 @OA\Property(property="branch", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Mariano Escobedo"),
     *                     @OA\Property(property="address", type="string", example="lorem ipsum"),
     *                     @OA\Property(property="status_id", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Property(property="links", type="object"),
     *     @OA\Property(property="meta", type="object")
     * ),
     * @OA\Response(
     *     response=401,
     *     description="No autorizado",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthorized")
     *     )
     * )
     */

    public function index(Request $request)
    {
        $users = $this->repository->searchAndPaginate($request);
        $users->getCollection()->transform(function ($user) {
            $role = $user->roles->first();
            $user->role_id = $role ? $role->id : null;
            $user->role = $role ?: null;
            $user->permissions = $user->getAllPermissions()->pluck('id');
            unset($user->roles);
            return $user;
        });

        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Registrar un nuevo usuario con perfil y asignar roles y permisos",
     *     tags={"Usuarios"},
     *     @OA\SecurityScheme(
     *         type="http",
     *         description="Bearer Token",
     *         name="Authorization",
     *         in="header",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         securityScheme="bearerAuth",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "status_id", "password", "name", "lastname", "second_lastname", "email", "branch_id", "role_id"},
     *             @OA\Property(property="username", type="string", example="usuario123"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="name", type="string", example="Sergio"),
     *             @OA\Property(property="lastname", type="string", example="Prueba"),
     *             @OA\Property(property="second_lastname", type="string", example="Prueba2"),
     *             @OA\Property(property="email", type="string", format="email", example="sergio@prueba.com"),
     *             @OA\Property(property="branch_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=2),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario registrado correctamente"),
     *             @OA\Property(property="user_id", type="integer", example=3),
     *             @OA\Property(property="username", type="string", example="usuario123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="username",
     *                     type="array",
     *                     @OA\Items(type="string", example="El campo username es obligatorio.")
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="El campo email debe ser una dirección de correo válida.")
     *                 )
     *             )
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

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->username,
            'status_id' => $request->status_id,
            'password' => Hash::make($request->password),
        ]);

        Profile::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'second_lastname' => $request->second_lastname,
            'email' => $request->email,
            'branch_id' => $request->branch_id,
            'user_id' => $user->id,
        ]);
        $user->syncRoles($request->input('role_id'));
        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }
        return response()->json([
            'status' => true,
            'message' => 'Usuario registrado correctamente',
            'user_id' => $user->id,
            'username' => $user->name,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user}",
     *     summary="Actualizar un usuario existente junto con su perfil, roles y permisos",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a actualizar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\SecurityScheme(
     *         type="http",
     *         description="Bearer Token",
     *         name="Authorization",
     *         in="header",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         securityScheme="bearerAuth",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "status_id", "name", "lastname", "second_lastname", "email", "branch_id", "role_id"},
     *             @OA\Property(property="username", type="string", example="usuario123"),
     *             @OA\Property(property="status_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Sergio"),
     *             @OA\Property(property="lastname", type="string", example="Prueba"),
     *             @OA\Property(property="second_lastname", type="string", example="Prueba2"),
     *             @OA\Property(property="email", type="string", format="email", example="sergio@prueba.com"),
     *             @OA\Property(property="branch_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=2),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La actualización fue correcta",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="La actualización fue correcta"),
     *             @OA\Property(property="user_id", type="integer", example=3),
     *             @OA\Property(property="username", type="string", example="usuario123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="username",
     *                     type="array",
     *                     @OA\Items(type="string", example="El campo username es obligatorio.")
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="El campo email debe ser una dirección de correo válida.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update([
            "name" => $request->username,
            'status_id' => $request->status_id,
        ]);

        $user->profile->update([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'second_lastname' => $request->second_lastname,
            'email' => $request->email,
            'branch_id' => $request->branch_id,
            'user_id' => $user->id,
        ]);
        $user->syncRoles($request->input('role_id'));
        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }
        return response()->json([
            'status' => true,
            'message' => 'La actualización fue correcta',
            'user_id' => $user->id,
            'username' => $user->name,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}/password",
     *     summary="Actualizar contraseña de usuarios",
     *     description="Actualiza la contraseña de usuario existente.",
     *     tags={"Usuarios"},
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
     *             @OA\Property(property="password", type="string", example="contraseñaSegura123"),
     *             @OA\Property(property="password_confirmation", type="string", example="contraseñaSegura123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status_id", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="username", type="string"),
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
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function updatePassword(UpdateUserPasswordRequest $request, User $user): JsonResponse
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => true,
            'message' => 'La actualización de contraseña fue correcta',
            'user_id' => $user->id,
            'username' => $user->name,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/active-records",
     *     summary="Obtener usuarios activos",
     *     description="Devuelve una lista de usuarios activos con sus nombres e IDs.",
     *     tags={"Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios activos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\AdditionalProperties(
     *                 type="string",
     *                 example={"1": "John Doe", "2": "Jane Smith"}
     *             )
     *         )
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
    public function activeRecords(): JsonResponse
    {
        $activeUsers = User::where('status_id', 1)->pluck('name', 'id');
        return response()->json($activeUsers);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/status/{status}",
     *     summary="Cambio de estado",
     *     description="Registro actualizado.",
     *     tags={"Modulos de usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
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
    public function changeStatus($id, $status): JsonResponse
    {
        $model = User::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }
/**
     * @OA\Post(
     *     path="/api/users/verifySupervisor",
     *     summary="Valida que contraseña y usuario ingresado sea correctos, ademas que el usuario tenga el rol de Supervisor",
     *     description="Crea un nuevo registro en base de datos.",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"user", "password"},
     *             @OA\Property(property="user", type="string", example="SARAM2024"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Usuario validado correctamente"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     )
     * )
     */
    public function verifySupervisor(UserValidateRequest $request):JsonResponse
    {
        $model = User::where('name', $request->user)->first();

        if($model->hasRole('Supervisor') && Hash::check($request->password, $model->password)){
            return response()->json("Usuario validado correctamente",200);
        }

        return response()->json("Credenciales incorrectas",401);
    }

}

