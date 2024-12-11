<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Http\Requests\StoreExchangeRateRequest;
use App\Http\Requests\UpdateExchangeRateRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeRateController extends Controller
{
    public function __construct(protected ISearchAndPaginate $repository)
    {}
    /**
     * @OA\Get(
     *     path="/api/exchange-rates/active",
     *     summary="Obtener tipos de cambio activos",
     *     description="Devuelve una lista de tipos de cambio activos con el ID y el valor del tipo de cambio (exchange).",
     *     tags={"Tipos de Cambio"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipos de cambio activos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="exchange", type="decimal", example="19.5")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron tipos de cambio activos."
     *     )
     * )
     */
    public function activeRecords(): JsonResponse
    {
        $activeExchangeRates = ExchangeRate::where('status_id', 1)->get(['id', 'exchange']);
        return response()->json($activeExchangeRates);
    }
    /**
     * @OA\Get(
     *     path="/api/exchange-rates",
     *     summary="Listado paginado de tipos de cambio",
     *     tags={"Tipos de Cambio"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Buscar por fecha o usuario",
     *         required=false,
     *         @OA\Schema(type="string", example="2024-10-15")
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
     *         description="Listado de tipos de cambio",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="exchange", type="decimal", example="19.5"),
     *                 @OA\Property(property="date", type="string", format="date", example="2024-10-15"),
     *                 @OA\Property(property="status_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
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
     *     path="/api/exchange-rates",
     *     summary="Crear un nuevo tipo de cambio",
     *     description="Crea un nuevo registro de tipo de cambio con los campos proporcionados.",
     *     tags={"Tipos de Cambio"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="exchange", type="decimal", example="19.5"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-10-15"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de cambio creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="exchange", type="decimal", example="19.5"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-10-15"),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-15T23:49:12Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-15T23:49:12Z")
     *         )
     *     )
     * )
     */

    public function store(StoreExchangeRateRequest $request)
    {
        $statusId = $request->input('status_id') ?? 1;
        $exchangeRate = ExchangeRate::create([
            'exchange' => $request->input('exchange'),
            'date' => $request->input('date'),
            'status_id' => $statusId,
            'user_id' => Auth::id(),
        ]);

        return response()->json($exchangeRate);
    }
    /**
     * @OA\Put(
     *     path="/api/exchange-rates/{id}",
     *     summary="Actualizar un tipo de cambio",
     *     description="Actualiza un tipo de cambio existente.",
     *     tags={"Tipos de Cambio"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tipo de cambio",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="exchange", type="decimal", example=19.5),
     *             @OA\Property(property="status_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de cambio actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="exchange", type="decimal", example=19.5),
     *             @OA\Property(property="status_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de cambio no encontrado"
     *     )
     * )
     */
    public function update(UpdateExchangeRateRequest $request, int $id)
    {
        $exchangeRate = ExchangeRate::findOrFail($id);
        $exchangeRate->update([
            'exchange' => $request->input('exchange'),
            'status_id' => $request->input('status_id'),
            'user_id' => Auth::id(),
        ]);
        $exchangeRate->save();
        return response()->json($exchangeRate);
    }

    /**
     * @OA\Patch(
     *     path="/api/exchange-rates/{id}/status",
     *     summary="Cambiar el estado de un tipo de cambio",
     *     description="Actualiza el estado de un tipo de cambio por ID.",
     *     tags={"Tipos de Cambio"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tipo de cambio",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Nuevo estado del tipo de cambio",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado del tipo de cambio actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="exchange", type="decimal", example="19.5"),
     *             @OA\Property(property="status_id", type="integer", example=2)
     *         )
     *     )
     * )
     */

    public function changeStatus($id, $status): JsonResponse
    {
        $exchangeRate = ExchangeRate::findOrFail($id);
        $exchangeRate->status_id = $status;
        $exchangeRate->save();
        return response()->json($exchangeRate);
    }

    /**
     * @OA\Get(
     *     path="/api/exchange-rates/{date}/date",
     *     summary="Búsqueda registro por fecha",
     *     description="Búsqueda de registro por fecha estado activo",
     *     tags={"Tipos de Cambio"},
     *     @OA\Response(
     *         response=200,
     *         description="Búsqueda de registro por fecha estado activo",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="exchange", type="decimal", example="19.5"),
     *                 @OA\Property(property="date", type="string", example="2024-10-10")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron tipos de cambio activos."
     *     )
     * )
     */
    public function fetchByDate($date): JsonResponse
    {
        $model = ExchangeRate::where('date', $date)
            ->where('status_id', 1)
            ->first(['id', 'exchange', 'date']);

        return response()->json($model);
    }

}
