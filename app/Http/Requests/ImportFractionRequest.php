<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ImportFractionRequest extends FormRequest
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
            "fractions" => "required|array",
            "fractions.*.name" => "required",
            "fractions.*.description" => "required",
            "fractions.*.level_product_id" => "required|exists:level_products,id",
            "fractions.*.status_id" => "required|exists:statuses,id",
        ];
    }

    public function messages(): array
    {
        return [
            "fractions.required" => "El campo fracciones es obligatorio",
            "fractions.array" => "El campo fracciones debe ser array",
            "fractions.*.name.required" => "Campo name es obligatorio",
            "fractions.*.description.required" => "Campo description es obligatorio",
            "fractions.*.level_product_id.required" => "Campo nivel de producto es obligatorio",
            "fractions.*.level_product_id.exists" => "Valor de nivel de producto ingresado no esta registrado",
            "fractions.*.status_id.required" => "El campo estatus es obligatorio",
            "fractions.*.status_id.exists" => "Valor de estatus ingresado no esta registrado",
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
