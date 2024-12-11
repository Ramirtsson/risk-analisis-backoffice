<?php

namespace App\Http\Controllers;

use App\Models\MFile;
use App\Http\Requests\StoreMFileRequest;
use App\Http\Requests\UpdateMFileRequest;

class MFileController extends Controller
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
    public function store(StoreMFileRequest $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMFileRequest $request, MFile $mFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MFile $mFile)
    {
        //
    }
}
