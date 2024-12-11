<?php

namespace App\Http\Controllers;

use App\Models\LevelProduct;
use App\Http\Requests\StoreLevelProductRequest;
use App\Http\Requests\UpdateLevelProductRequest;
use Illuminate\Http\JsonResponse;

class LevelProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelProductRequest $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelProductRequest $request, LevelProduct $levelProduct)
    {
        //
    }

    public function changeStatus($id, $status): JsonResponse
    {
        return response()->json('model');
    }

    public function activeRecords(): JsonResponse
    {
        $collection = LevelProduct::where('status_id', 1)->select('name', 'id')->get();
        return response()->json($collection);
    }
}
