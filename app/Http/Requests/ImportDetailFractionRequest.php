<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ImportDetailFractionRequest extends FormRequest
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
            "detailFractions" => "required|array",
            "detailFractions.*.name" => "required",
            "detailFractions.*.description" => "required",
            "detailFractions.*.status_id" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "detailFractions.required" => "El campo fracciones es obligatorio",
            "detailFractions.array" => "El campo fracciones debe ser array",
            "detailFractions.*.name.required" => "Campo name es requerido",
            "detailFractions.*.description.required" => "Campo name es requerido",
            "detailFractions.*.status_id.required" => "Campo estatus es requerido"
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
