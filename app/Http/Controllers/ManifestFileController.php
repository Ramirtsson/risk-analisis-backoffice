<?php

namespace App\Http\Controllers;

use App\Models\ManifestFile;
use App\Http\Requests\StoreManifestFileRequest;
use App\Http\Requests\UpdateManifestFileRequest;
use App\Services\Images\ImageService;
use Illuminate\Support\Facades\Response;

class ManifestFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManifestFileRequest $request)
    {
        $ruta= (new ImageService('public', '/documents'))->store($request->file('file'));
        $query = ManifestFile::create([
            "manifest_id" => $request->input('manifest_id'),
            "type_manifest_document_id" => $request->input('type_manifest_document_id'),
            "path" => $ruta,
            "file"=> $request->file('file')->getClientOriginalName(),
            "status_id"=>1,
            "user_id" => Auth()->id()
        ]);
        return response()->json($query, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ManifestFile $manifestFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManifestFile $manifestFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManifestFileRequest $request, ManifestFile $manifestFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManifestFile $manifestFile)
    {
        $delete = (new ImageService('public', '/documents'))->delete($manifestFile->path);
        
        if($delete) $manifestFile->delete();
        
        return response()->json("Archivo Eliminado Correctamente", 201);
    }

    public function download(ManifestFile $manifestFile){

        $filePath = public_path($manifestFile->path);

        if (file_exists($filePath)) {
            return Response::download($filePath);
        }

        return response()->json(['message' => 'No se encontro el archivo'], 404);
    }
}
