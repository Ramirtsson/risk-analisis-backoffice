<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCourierCompanyRequest extends FormRequest
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
            "social_reason" => "required|string|max:70",
            "tax_domicile" => "required|string|max:300",
            "tax_id" => "required|string|max:25",
            "validity" => "required|integer",
            "registration" => "required|string|max:4",
            "status_id" => "required|exists:statuses,id",
        ];
    }

    public function messages(){
        return [
            "social_reason.required" => "El campo razon social es obligatorio",
            "social_reason.max" => "El campo razon social excede la longitud de caracteres permitidos, maximo (70)",
            "tax_domicile.required" => "El campo Domicilio es obligatorio",
            "tax_domicile.max" => "El campo Domicilio excede la longitud de caracteres permitidos, maximo (300)",
            "tax_id.required" => "El campo tax id es obligatorio",
            "tax_id.max" => "El campo tax id es obligatorio excede la longitud de caracteres permitidos, maximo (25)",
            "validity.required" => "El campo valicacion es obligatorio",
            "registration.required" => "El campo registro es obligatorio",
            "registration.max" => "El campo registro excede la longitud de caracteres permitidos, maximo (4)",
            "status_id.required" => "El campo estatus es obligatorio",
            "status_id.exists" => "usuario no encontrado",
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
