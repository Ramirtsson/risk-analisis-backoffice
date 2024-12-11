<?php

namespace App\Http\Controllers;

use App\Models\RectifiedManifest;
use App\Http\Requests\StoreRectifiedManifestRequest;
use App\Http\Requests\UpdateRectifiedManifestRequest;

class RectifiedManifestController extends Controller
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
    public function store(StoreRectifiedManifestRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRectifiedManifestRequest $request, RectifiedManifest $rectifiedManifest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RectifiedManifest $rectifiedManifest)
    {
        //
    }
}
