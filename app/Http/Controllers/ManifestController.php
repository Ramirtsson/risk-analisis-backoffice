<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use App\Http\Requests\StoreManifestRequest;
use App\Http\Requests\UpdateManifestRequest;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManifestController extends Controller
{

    public function __construct(protected ISearchAndPaginate $repository)
    {}

    /**
     * @OA\Get(
     *     path="/api/manifests",
     *     summary="Listado de manifiestos paginados ordenados de forma descendente por id de registro.",
     *     tags={"Manifiestos"},
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
     *         description="Lista de manifiestos",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="import_request", type="string", example="SedQuis"),
     *                 @OA\Property(property="number_guide", type="string", example="Corrupti"),
     *                 @OA\Property(property="manifest_file", type="string", example="XXX.xlsx"),
     *                 @OA\Property(property="rectified", type="boolean", example="0"),
     *                 @OA\Property(property="checked", type="boolean", example="0"),
     *                            @OA\Property(property="status", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Activo"),
     *                   ),
     *                             @OA\Property(property="operatingStatus", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Prealerta"),
     *                   ),
     *                         @OA\Property(property="mFile", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="XXX.txt"),
     *                   ),
     *                        @OA\Property(property="customAgent", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="JOSE MARTIN DOMINGUEZ MURO"),
     *                           @OA\Property(property="patent", type="string", example="3296"),
     *                   ),
     *                         @OA\Property(property="customer", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Ferry-Lindgren"),
     *                   ),
     *                          @OA\Property(property="customHouse", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="AGUA PRIETA, AGUA PRIETA, SONORA."),
     *                           @OA\Property(property="code", type="string", example="20"),
     *                   ),
     *             )),
     *
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
     *     path="/api/manifests",
     *     summary="Crear un nuevo registro manifiesto",
     *     description="Crea una nuevo registro en base de datos.",
     *     tags={"Manifiestos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={
     *                       "import_request",
     *                       "arrival_date",
     *                       "modulation_date",
     *                       "number_guide",
     *                       "house_guide",
     *                       "lumps",
     *                       "gross_weight",
     *                       "packages",
     *                       "registration_number",
     *                       "invoice",
     *                       "invoice_date",
     *                       "rectified",
     *                       "total_invoice",
     *                       "transmission_date",
     *                       "customer_id",
     *                       "custom_agent_id",
     *                       "custom_house_id",
     *                       "courier_company_id",
     *                       "supplier_id",
     *                       "traffic_id",
     *                       "value_id",
     *                       "exchange_rate_id",
     *                       "currency_id",
     *                       "warehouse_office_id",
     *                       "warehouse_origin_id",
     *                       "operating_status_id",
     *                       "status_id",
     *          },
     *             @OA\Property(property="id", type="string", example="1"),
     *             @OA\Property(property="arrival_date", type="string", example="2024-28-10"),
     *             @OA\Property(property="modulation_date", type="string", example="2024-28-10"),
     *             @OA\Property(property="number_guide", type="string", example="XXX11"),
     *             @OA\Property(property="house_guide", type="string", example="ZZZZWE"),
     *             @OA\Property(property="lumps", type="string", example="122"),
     *             @OA\Property(property="gross_weight", type="string", example="12"),
     *             @OA\Property(property="packages", type="string", example="2"),
     *             @OA\Property(property="registration_number", type="string", example="58697"),
     *             @OA\Property(property="invoice", type="string", example="99922"),
     *             @OA\Property(property="invoice_date", type="string", example="2024-11-25"),
     *             @OA\Property(property="rectified", type="boolean", example="0"),
     *             @OA\Property(property="total_invoice", type="string", example="120.22"),
     *             @OA\Property(property="transmission_date", type="string", example="2024-11-25"),
     *             @OA\Property(property="payment_date", type="string", example="2024-11-25"),
     *             @OA\Property(property="customer_id", type="string", example="1"),
     *             @OA\Property(property="custom_agent_id", type="string", example="1"),
     *             @OA\Property(property="custom_house_id", type="string", example="1"),
     *             @OA\Property(property="courier_company_id", type="string", example="1"),
     *             @OA\Property(property="supplier_id", type="string", example="1"),
     *             @OA\Property(property="traffic_id", type="string", example="1"),
     *             @OA\Property(property="value_id", type="string", example="1"),
     *             @OA\Property(property="exchange_rate_id", type="string", example="1"),
     *             @OA\Property(property="currency_id", type="string", example="1"),
     *             @OA\Property(property="warehouse_office_id", type="string", example="1"),
     *             @OA\Property(property="warehouse_origin_id", type="string", example="1"),
     *             @OA\Property(property="operating_status_id", type="string", example="2"),
     *             @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="arrival_date", type="string", example="2024-28-10"),
     *              @OA\Property(property="modulation_date", type="string", example="2024-28-10"),
     *              @OA\Property(property="number_guide", type="string", example="XXX11"),
     *              @OA\Property(property="house_guide", type="string", example="ZZZZWE"),
     *              @OA\Property(property="lumps", type="string", example="122"),
     *              @OA\Property(property="gross_weight", type="string", example="12"),
     *              @OA\Property(property="packages", type="string", example="2"),
     *              @OA\Property(property="registration_number", type="string", example="58697"),
     *              @OA\Property(property="invoice", type="string", example="99922"),
     *              @OA\Property(property="invoice_date", type="string", example="2024-11-25"),
     *              @OA\Property(property="rectified", type="boolean", example="0"),
     *              @OA\Property(property="total_invoice", type="string", example="120.22"),
     *              @OA\Property(property="transmission_date", type="string", example="2024-11-25"),
     *              @OA\Property(property="payment_date", type="string", example="2024-11-25"),
     *              @OA\Property(property="customer_id", type="string", example="1"),
     *              @OA\Property(property="custom_agent_id", type="string", example="1"),
     *              @OA\Property(property="custom_house_id", type="string", example="1"),
     *              @OA\Property(property="courier_company_id", type="string", example="1"),
     *              @OA\Property(property="supplier_id", type="string", example="1"),
     *              @OA\Property(property="traffic_id", type="string", example="1"),
     *              @OA\Property(property="value_id", type="string", example="1"),
     *              @OA\Property(property="exchange_rate_id", type="string", example="1"),
     *              @OA\Property(property="currency_id", type="string", example="1"),
     *              @OA\Property(property="warehouse_office_id", type="string", example="1"),
     *              @OA\Property(property="warehouse_origin_id", type="string", example="1"),
     *              @OA\Property(property="operating_status_id", type="string", example="2"),
     *              @OA\Property(property="status_id", type="string", example="1"),
     *         )
     *     ),
     * )
     */
    public function store(StoreManifestRequest $request): JsonResponse
    {
        data_fill($request, 'user_id', auth()->id());
        $model = $this->repository->store($request->all());
        return response()->json($model);
    }
/**
     * @OA\Get(
     *     path="/api/manifests/{id}",
     *     summary="Listado de manifiesto por id de registro.",
     *     tags={"Manifiestos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
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
     *     @OA\Response(
     *         response=200,
     *         description="Lista de manifiestos",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="import_request", type="string", example="11111"),
     *                 @OA\Property(property="arrival_date", type="string", example="2024-10-30"),
     *                 @OA\Property(property="modulation_date", type="string", example="2024-10-24"),
     *                 @OA\Property(property="number_guide", type="string", example="6666"),
     *                 @OA\Property(property="house_guide", type="string", example="6666"),
     *                 @OA\Property(property="lumps", type="string", example="1.000"),
     *                 @OA\Property(property="gross_weight", type="string", example="1.000"),
     *                 @OA\Property(property="packages", type="string", example="1"),
     *                 @OA\Property(property="registration_number", type="string", example="138"),
     *                 @OA\Property(property="invoice", type="string", example="1111"),
     *                 @OA\Property(property="invoice_date", type="string", example="2024-10-01"),
     *                 @OA\Property(property="rectified", type="string", example="0"),
     *                 @OA\Property(property="total_invoice", type="string", example="125"),
     *                 @OA\Property(property="transmission_date", type="string", example="2024-10-01"),
     *                 @OA\Property(property="payment_date", type="string", example="2024-10-31"),
     *                 @OA\Property(property="checked", type="string", example="1"),
     *                 @OA\Property(property="customer_id", type="string", example="1"),
     *                 @OA\Property(property="custom_agent_id", type="string", example="1"),
     *                 @OA\Property(property="custom_house_id", type="string", example="1"),
     *                 @OA\Property(property="courier_company_id", type="string", example="1"),
     *                 @OA\Property(property="supplier_id", type="string", example="1"),
     *                 @OA\Property(property="traffic_id", type="string", example="1"),
     *                 @OA\Property(property="value_id", type="string", example="1"),
     *                 @OA\Property(property="exchange_rate_id", type="string", example="1"),
     *                 @OA\Property(property="currency_id", type="string", example="1"),
     *                 @OA\Property(property="warehouse_office_id", type="string", example="1"),
     *                 @OA\Property(property="warehouse_origin_id", type="string", example="1"),
     *                 @OA\Property(property="operating_status_id", type="string", example="1"),
     *                 @OA\Property(property="user_id", type="string", example="1"),
     *                 @OA\Property(property="status_id", type="string", example="1"),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-30T23:49:17.590000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-30T23:49:17.590000Z"),
     *                            @OA\Property(property="status", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Activo"),
     *                   ),
     *                             @OA\Property(property="operatingStatus", type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Prealerta"),
     *                   )
     *             )),
     *
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
    public function show($id): JsonResponse
    {
        $collection = Manifest::with("rectifiedManifests")->where("id",$id)->get();
        return response()->json($collection);
    }
    /**
     * @OA\Put(
     *     path="/api/manifests/{id}",
     *     summary="Actualizar registro",
     *     description="Actualiza la información especifica de un registro.",
     *     tags={"Manifiestos"},
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
     *             @OA\Property(property="rectified", type="integer", example="0"),
     *             @OA\Property(property="manifest", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="import_request", type="string", example="11111"),
     *                     @OA\Property(property="arrival_date", type="string", example="2024-10-01"),
     *                     @OA\Property(property="modulation_date", type="string", example="2024-10-01"),
     *                     @OA\Property(property="number_guide", type="string", example="6666"),
     *                     @OA\Property(property="house_guide", type="string", example="6666"),
     *                     @OA\Property(property="lumps", type="string", example="1.000"),
     *                     @OA\Property(property="gross_weight", type="string", example="1.000"),
     *                     @OA\Property(property="packages", type="string", example="1"),
     *                     @OA\Property(property="registration_number", type="string", example="138"),
     *                     @OA\Property(property="invoice", type="string", example="1111"),
     *                     @OA\Property(property="invoice_date", type="string", example="2024-10-01"),
     *                     @OA\Property(property="rectified", type="string", example="0"),
     *                     @OA\Property(property="total_invoice", type="string", example="125"),
     *                     @OA\Property(property="transmission_date", type="string", example="2024-10-01"),
     *                     @OA\Property(property="customer_id", type="string", example="1"),
     *                     @OA\Property(property="custom_agent_id", type="string", example="1"),
     *                     @OA\Property(property="custom_house_id", type="string", example="1"),
     *                     @OA\Property(property="courier_company_id", type="string", example="1"),
     *                     @OA\Property(property="supplier_id", type="string", example="1"),
     *                     @OA\Property(property="traffic_id", type="string", example="1"),
     *                     @OA\Property(property="value_id", type="string", example="1"),
     *                     @OA\Property(property="exchange_rate_id", type="string", example="1"),
     *                     @OA\Property(property="currency_id", type="string", example="1"),
     *                     @OA\Property(property="warehouse_office_id", type="string", example="1"),
     *                     @OA\Property(property="warehouse_origin_id", type="string", example="1"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Manifiesto actualizado correctamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="---"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="---"
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="---",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized")
     *           )
     *       )
     * )
     */
    public function update(UpdateManifestRequest $request, Manifest $manifest)
    {
        $collection = $manifest->update($request->validated()["manifest"][0]);

        if($request->validated()["rectified"] == 1){

            $rectifiedManifest = $request->validated()["rectifiedManifest"][0];
            $rectifiedManifest["manifest_id"]=$manifest->id;
            $rectifiedManifest["payment_date"]=$rectifiedManifest["r_payment_date"];
            $rectifiedManifest["modulation_date"]=$rectifiedManifest["r_modulation_date"];
            $rectifiedManifest["user_id"]= Auth::id();

            $manifest->rectifiedManifests()->updateOrCreate(['manifest_id'=> $manifest->id],$rectifiedManifest);
        }else{
            $rectifiedManifestRelation =  $manifest->rectifiedManifests();

            if ($rectifiedManifestRelation) {
                $rectifiedManifestRelation->delete();
            }
        }

        return response()->json("Manifiesto actualizado correctamente",200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manifest $manifest)
    {
        //
    }

    /**
     * @OA\Patch(
     *     path="/api/manifests/{id}/status/{status}",
     *     summary="Cambio estado de registro",
     *     description="Registro actualizado.",
     *     tags={"Manifiestos"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="import_request", type="string"),
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
        $model = Manifest::findOrFail($id);
        $model->status_id = $status;
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Patch(
     *     path="/api/manifests/{id}/operating-status/{status}",
     *     summary="Cambio de estado de operación(manifiesto)",
     *     description="Actualizar estado de operación.",
     *     tags={"Manifiestos"},
     *     @OA\Response(
     *         response=200,
     *         description="---",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="status_id", type="integer"),
     *                     @OA\Property(property="operating_status_id", type="string"),
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
    public function changeOperatingStatus($id, $operatingStatus): JsonResponse
    {
        $model = Manifest::findOrFail($id);
        $model->operating_status_id = $operatingStatus;
        $model->save();
        return response()->json($model);
    }
}
