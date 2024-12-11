<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AuthUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "id" => $request->user()->id,
            "user_name" => $request->user()->name,
            "first_name" => $request->user()->profile->name,
            "last_name" => $request->user()->profile->last_name,
            "second_lastname" => $request->user()->profile->second_lastname,
            'fullName' => Str::title(
                "{$request->user()->profile->name} {$request->user()->profile->last_name} {$request->user()->profile->second_lastname}" ),
            "email" => $request->user()->profile->email,
            "roles" => $request->user()->roles,
            "permissions" => $request->user()->permissions,
        ], 200);
    }
}
