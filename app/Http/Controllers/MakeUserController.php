<?php

namespace App\Http\Controllers;
use App\Services\Users\UserNameYear;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class MakeUserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/make-user",
     *     summary="Genera nombre de usuario en base a las iniciales de apellidos y nombre",
     *     description="Generar nombre de usuario concatenando el año en curso.",
     *     operationId="makeUserNameWithYear",
     *     tags={"Generar nombre de usuario"},
     *     @OA\Parameter(
     *      name="last_name",
     *      in="query",
     *      description="Apellido Paterno",
     *      required=true,
     *  @OA\Schema(
     *      type="string"
     *       )
     *       ),
     *     @OA\Parameter(
     *      name="second_lastname",
     *      in="query",
     *      description="Apellido Materno",
     *      required=true,
     *  @OA\Schema(
     *      type="string"
     *       )
     *       ),
     *     @OA\Parameter(
     *      name="name",
     *      in="query",
     *      description="Nombre",
     *      required=true,
     *  @OA\Schema(
     *      type="string"
     *       )
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"second_lastname", "last_name", "name"},
     *             @OA\Property(property="second_lastname", type="string", example="sanchez"),
     *             @OA\Property(property="last_name", type="string", example="sandoval"),
     *             @OA\Property(property="name", type="string", example="karen")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Nombre de usuario con año generado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="nameWithYear", type="string", example="SASAK2024")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Los datos proporcionados no son válidos.",
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'second_lastname' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'name' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $e->errors()
            ], 400);
        }

        $items = [
            $validatedData['second_lastname'],
            $validatedData['last_name'],
            $validatedData['name'],
        ];

        $userNameYear = new UserNameYear($items);
        $nameWithYear = $userNameYear->makeNameWithYear();

        return response()->json(['nameWithYear' => $nameWithYear], 200);
    }
}
