<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AccountNexenController extends Controller
{
    public function activeRecords(): JsonResponse
    {
        
        return response()->json("example");
    }

    public function accountsById($id): JsonResponse
    {
        return response()->json("example");
    }
}
