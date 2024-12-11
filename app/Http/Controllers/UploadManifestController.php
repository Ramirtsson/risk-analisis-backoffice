<?php

namespace App\Http\Controllers;

use App\Imports\GetColumnCount;
use App\Imports\ManifestImport;
use App\Models\Manifest;
use App\Services\Images\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class UploadManifestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
            'manifest_id' => 'required|exists:manifests,id',
        ],[
            'file.file' => 'Archivo debe ser formato: xlsx',
            'file.mimes' => 'Archivo debe ser formato: xlsx',
            'file.required' => 'Campo archivo es obligatorio',
            'manifest_id.required' => 'Id de manifiesto obligatorio',
            'manifest_id.exists' => 'Manifiesto no existe',
        ]);

        //buscar y validar existencia de arhivo en tabla de manifiestos
        $manifest = Manifest::findOrFail($request->input('manifest_id'));

        try {

            $importColumns = new GetColumnCount();
            Excel::import($importColumns, $request->file('file'));
            $columnCount = $importColumns->getColumnCount();

            $maxParameters = 2100;
            $batchSize = floor($maxParameters / ++$columnCount);

            $importFile = new ManifestImport($manifest, intval($batchSize));
            Excel::import($importFile, $request->file('file'));

            $manifest->total_invoice = $importFile->getTotalDeclared();

            $path = (new ImageService('public', '/manifests'))->store($request->file('file'));
            $manifest->manifest_file = $path;
            $manifest->save();

            return response()->json(['message' => 'Archivo procesado exitosamente.']);
        }catch (ValidationException $exception) {
            return response()->json($exception->failures(),500);
        }
    }
}
