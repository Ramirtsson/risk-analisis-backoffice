<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccessAPIDocumentationController extends Controller
{
    private const EXPIRE_TOKEN = 30;

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Autenticar usuario para probar Documentacion API",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user","password"},
     *             @OA\Property(property="user", type="string", example="johndoe"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autenticación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="Bearer eyJ0eXAiOiJKV1QiLC..."),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_at", type="string", example="2024-12-31 23:59:59")
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
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string'
        ]);
        $credentials = $request->only(['user', 'password']);
        if(!$this->attemptLogin($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $this->findUserModel($credentials);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMinutes(self::EXPIRE_TOKEN);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    protected function attemptLogin($credentials): bool
    {
        $user = $this->findUserModel($credentials);
        if ($user && Hash::check($credentials['password'], $user->password)) {
            return true;
        }

        return false;
    }

    private function findUserModel(array $credentials)
    {
        return (new UserRepository())->findBy($credentials['user'],'name');
    }
}
