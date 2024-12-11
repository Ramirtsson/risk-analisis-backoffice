<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreManifestFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "manifest_id" => "required|exists:manifests,id",
            "type_manifest_document_id" => "required|exists:type_manifest_documents,id",
            "file" => "required|mimes:pdf",
        ];
    }

    public function messages(){
        return [
            "manifest_id.required" => "El campo manifiesto es obligatorio",
            "manifest_id.exists" => "El campo manifiesto es invalido",
            "type_manifest_document_id.required" => "El campo documento manifiesto es obligatorio",
            "type_manifest_document_id.exists" => "El campo documento manifiesto es invalido",
            "file.required" => "El campo archivo es obligatorio",
            "file.mimes" => "El valor archivo no es permitido",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422));
    }
}
