<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomAgentCustomHouse;
use App\Models\CustomsAgent;
use App\Http\Requests\StoreCustomsAgentRequest;
use App\Http\Requests\UpdateCustomsAgentRequest;
use App\Models\CustomAgentCustomHouse;
use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomsAgentController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    /**
     * @OA\Get(
     *     path="/api/customs-agent",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Agente Aduanal"},
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
     *             example="JOSE MARTIN DOMINGUEZ MURO"
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
     *                 @OA\Property(property="patent", type="string"),
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
     *     path="/api/customs-agent",
     *     summary="Crear un nuevo registro de Agente Aduanal",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Agente Aduanal"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "patent","status_id"},
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="patent", type="string", example="patent"),
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
     *             @OA\Property(property="patent", type="string"),
     *             @OA\Property(property="status_id", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */

    public function store(StoreCustomsAgentRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $model = CustomsAgent::create($data);
        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/api/customs-agent/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza Agente Aduanal existente.",
     *     tags={"Agente Aduanal"},
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
     *             required={"name", "patent","status_id"},
     *             @OA\Property(property="name", type="string", example="nameEditado"),
     *             @OA\Property(property="patent", type="string", example="1231e"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Agente Aduanal actualizado correctamente",
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

     public function update(UpdateCustomsAgentRequest $request, CustomsAgent $customsAgent)
     {
         $data = $request->validated();
         $data["user_id"] = Auth::id();
         $customsAgent->update($data);
         return response()->json("Agente Aduanal actualizado correctamente",201);
     }

        /**
     * @OA\Patch(
     *     path="/api/customs-agent/{id}/status/{status}",
     *     summary="Marcar un registro de Agente Aduanal como inactivo o activo.",
     *     description="Actualiza el estado de una Agente Aduanal a inactivo (status_id = 2), o activo (status_id = 1)",
     *     tags={"Agente Aduanal"},
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
     *                 @OA\Property(property="patent", type="string"),
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
     *         description="Agente Aduanal no encontrado."
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
        $model = CustomsAgent::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/customs-agent/active-records",
     *     summary="Listado de Agente Aduanal con estatus activo",
     *     description="Devuelve un listado de Agente Aduanal con estatus activo.",
     *     tags={"Agente Aduanal"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="patent", type="string"),
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
        $collection = CustomsAgent::where('status_id', 1)->select('name', 'patent','id')->get();
        return response()->json($collection);
    }

    /**
     * @OA\Post(
     *     path="/api/customs-agent/{id}/custom-agent-custom-house",
     *     summary="Asociar casas aduanales a un agente aduanal",
     *     description="Elimina las asociaciones actuales y crea nuevas asociaciones de casas aduanales para el agente especificado.",
     *     operationId="associateCustomHouseWithAgent",
     *     tags={"Agente Aduanal"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del agente aduanal",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         description="Lista de nuevas asociaciones de casas aduanales para el agente aduanal",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="custom_houses",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="custom_agent_id", type="integer", example=1),
     *                     @OA\Property(property="custom_house_id", type="integer", example=120),
     *                     @OA\Property(property="checked", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Asociaciones de casas aduanales creadas exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="custom_agent_id", type="integer", example=1),
     *                 @OA\Property(property="custom_house_id", type="integer", example=120),
     *                 @OA\Property(property="checked", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud no válida"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Agente aduanal no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function customAgentcustomHouse(StoreCustomAgentCustomHouse $request,$id){

        CustomAgentCustomHouse::where("custom_agent_id", $id)->delete();

        $model = CustomAgentCustomHouse::insert($request->input("custom_houses"));
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/customs-agent/{id}/customs-house",
     *     summary="Obtener las casas aduanales asociadas a un agente aduanal",
     *     description="Devuelve la información de un agente aduanal con las casas aduanales asociadas, incluyendo el nombre y código de cada casa aduanal.",
     *     operationId="getCustomsHouseByAgentId",
     *     tags={"Agente Aduanal"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del agente aduanal",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Agente aduanal con casas aduanales asociadas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="JOSE MARTIN DOMINGUEZ MURO"),
     *                 @OA\Property(property="patent", type="string", example="3296"),
     *                 @OA\Property(property="status_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-24T18:40:41.017000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-24T18:40:41.017000Z"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Activo")
     *                 ),
     *                 @OA\Property(
     *                     property="custom_agent_custom_house",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="custom_agent_id", type="integer", example=1),
     *                         @OA\Property(property="custom_house_id", type="integer", example=120),
     *                         @OA\Property(property="checked", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="AEROPUERTO INTERNACIONAL FELIPE ÁNGELES, SANTA LUCÍA, ZUMPANGO, ESTADO DE MÉXICO"),
     *                         @OA\Property(property="code", type="string", example="850"),
     *                         @OA\Property(
     *                             property="custom_house",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=120),
     *                             @OA\Property(property="name", type="string", example="AEROPUERTO INTERNACIONAL FELIPE ÁNGELES, SANTA LUCÍA, ZUMPANGO, ESTADO DE MÉXICO"),
     *                             @OA\Property(property="code", type="string", example="850"),
     *                             @OA\Property(property="status_id", type="integer", example=1),
     *                             @OA\Property(property="user_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-24T19:42:34.517000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-24T19:42:34.517000Z"),
     *                             @OA\Property(
     *                                 property="status",
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="Activo")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Agente aduanal no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function customsHouse($id): JsonResponse
    {
        $customAgent = CustomsAgent::with('customAgentCustomHouse')->findOrFail($id);
        
        $customAgent->customAgentCustomHouse->transform(function ($customHouse) {
            $customHouse->name = $customHouse->customHouse->name;
            $customHouse->code = $customHouse->customHouse->code;
            return $customHouse;
        });
        $data = [$customAgent];

        return response()->json($data);
    }
}
