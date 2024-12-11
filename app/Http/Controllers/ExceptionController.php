<?php

namespace App\Http\Controllers;

use App\Models\Exception;
use App\Http\Requests\StoreExceptionRequest;
use App\Http\Requests\UpdateExceptionRequest;
use App\Models\DetailExceptionFraction;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ExceptionController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    
    /**
     * @OA\Get(
     *     path="/api/exceptions",
     *     summary="Listado paginado ordenado de forma descendente por id de registro.",
     *     tags={"Excepciones Fracciones"},
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
     *             example="--"
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
     *                 @OA\Property(property="code_id", type="integer"),
     *                 @OA\Property(property="complement1", type="string"),
     *                 @OA\Property(property="complement2", type="string"),
     *                 @OA\Property(property="complement3", type="string"),
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
     *     path="/api/exceptions",
     *     summary="Crear un nuevo registro de excepcion",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Excepciones Fracciones"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","code_id","status_id","complement1","complement2","complement3"},
     *             @OA\Property(property="name", type="string", example="Exception"),
     *             @OA\Property(property="code_id", type="string", example="1"),
     *             @OA\Property(property="complement1", type="string", example="1"),
     *             @OA\Property(property="complement2", type="string", example="complemento 2"),
     *             @OA\Property(property="complement3", type="string", example="complemento 3"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="name"),
     *             @OA\Property(property="code_id", type="string", example="123"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *             @OA\Property(property="user_id", type="string", example="1"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     * )
    */
    public function store(StoreExceptionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        DB::beginTransaction();
        try {
            $model = Exception::create($data);
            $detailExceptionFraction = new DetailExceptionFraction([
                'detail_fraction_id' => $request->detail_fraction_id,
                'fraction_id' => $request->fraction_id,
                'exception_id' => $model->id,
            ]);
            $detailExceptionFraction->save();

            $exceptionWithRelations = DetailExceptionFraction::with(['fraction', 'detailFraction', 'exception'])
                ->where('exception_id', $model->id)
                ->first();

            DB::commit();

            return response()->json($exceptionWithRelations);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/exceptions/{id}",
     *     summary="Actualizar registro por id",
     *     description="Actualiza excepcion existente.",
     *     tags={"Excepciones Fracciones"},
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
     *             required={"name","code_id","status_id","complement1","complement2","complement3"},
     *             @OA\Property(property="name", type="string", example="Exception Edit"),
     *             @OA\Property(property="code_id", type="string", example="1"),
     *             @OA\Property(property="complement1", type="string", example="1"),
     *             @OA\Property(property="complement2", type="string", example="complemento 2"),
     *             @OA\Property(property="complement3", type="string", example="complemento 3"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Clave de Sistema Kasa actualizado correctamente",
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

     public function update(UpdateExceptionRequest $request, Exception $exception): JsonResponse
     {
         $data["user_id"] = Auth::id();
         $data = $request->validated();
         DB::beginTransaction();
         try {
             $exception->update($data);

             $detailExceptionFraction = DetailExceptionFraction::where('exception_id', $exception->id)->first();

             if ($detailExceptionFraction) {
                 $detailExceptionFraction->fraction_id = $request->input('fraction_id');
                 $detailExceptionFraction->detail_fraction_id = $request->input('detail_fraction_id');
                 $detailExceptionFraction->save();
             } else {
                 throw new \Exception('No se encontró ningún registro', 404);
             }

             DB::commit();

             return response()->json(['message' => 'Registro actualizado con éxito', 'data' => $detailExceptionFraction]);
         }catch (\Exception $exception){
             return response()->json($exception->getMessage(), 400);
         }
     }

    /**
     * @OA\Get(
     *     path="/api/exceptions/{id}/status/{status}",
     *     summary="Listado de estado activo",
     *     description="Devuelve un listado estado activo (status_id = 1).",
     *     tags={"Excepciones Fracciones"},
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
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontrarón registros en base de datos."
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
        $model = Exception::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/api/exceptions/active-records",
     *     summary="Listado de excepcion con estatus activo",
     *     description="Devuelve un listado de excepciones estado activo.",
     *     tags={"Excepciones Fracciones"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="code_id", type="integer"),
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
        $collection = Exception::where('status_id', 1)->select('name','id')->get();
        return response()->json($collection);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $collection = $this->repository->showDetailExceptionFractions($request, $id);
        return response()->json($collection);
    }
}
