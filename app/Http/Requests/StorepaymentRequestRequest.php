<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorepaymentRequestRequest extends FormRequest
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
            'manifest_id' => 'required|integer|exists:manifests,id',
            'account_id' => 'required|integer',
            'request_type_id' => 'required|integer|exists:request_types,id',
            'payment_information.tconcept_id' => 'required|integer|exists:t_concepts,id',
            'payment_information.observations' => 'nullable|string|max:500',
            'payment_information.payment_amount' => 'required|numeric|min:0',
            'payment_information.currency_id' => 'required|integer|exists:currencies,id',
            'documents' => 'required|min:1',
            'documents.*.file_type_id' => 'required|integer|exists:file_types,id',
            'documents.*.file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            '*.manifest_id.required' => 'El campo manifesto es obligatorio.',
            '*.manifest_id.integer' => 'El campo manifesto debe ser un número entero.',
            '*.manifest_id.exists' => 'El campo manifesto no existe en la base de datos.',
            '*.account_id.required' => 'El campo cuenta es obligatorio.',
            '*.account_id.integer' => 'El campo cuenta debe ser un número entero.',
            '*.account_id.exists' => 'El campo cuenta no existe en la base de datos.',
            '*.request_type.required' => 'El campo tipo de solicitud es obligatorio.',
            '*.request_type.integer' => 'El campo tipo de solicitud debe ser un número entero.',
            '*.request_type.exists' => 'El campo tipo de solicitud no existe en la base de datos.',
            '*.payment_information.concept_id.required' => 'El campo concepto es obligatorio.',
            '*.payment_information.concept_id.integer' => 'El campo concepto debe ser un número entero.',
            '*.payment_information.concept_id.exists' => 'El campo concepto no existe en la base de datos.',
            '*.payment_information.observations.string' => 'El campo observaciones debe ser un texto.',
            '*.payment_information.observations.max' => 'El campo observaciones no puede exceder los 500 caracteres.',
            '*.payment_information.payment_amount.required' => 'El campo importe del pago es obligatorio.',
            '*.payment_information.payment_amount.numeric' => 'El campo importe del pago debe ser un número.',
            '*.payment_information.payment_amount.min' => 'El campo importe del pago debe ser un valor positivo.',
            '*.payment_information.currency_id.required' => 'El campo moneda es obligatorio.',
            '*.payment_information.currency_id.integer' => 'El campo moneda debe ser un número entero.',
            '*.payment_information.currency_id.exists' => 'El campo moneda no existe en la base de datos.',
            '*.documents.required' => 'Debe incluir al menos un documento.',
            '*.documents.min' => 'Debe incluir al menos un documento.',
            '*.documents.*.file_type_id.required' => 'El campo tipo de archivo es obligatorio.',
            '*.documents.*.file_type_id.integer' => 'El campo tipo de archivo debe ser un número entero.',
            '*.documents.*.file_type_id.exists' => 'El campo tipo de archivo no existe en la base de datos.',
            '*.documents.*.file.required' => 'El campo archivo es obligatorio.',
            '*.documents.*.file.file' => 'El campo archivo debe ser un archivo.',
            '*.documents.*.file.mimes' => 'El archivo debe ser de tipo pdf, doc, docx,jpg o jpeg.',
            '*.documents.*.file.max' => 'El tamaño máximo del archivo es 2 MB.',
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
