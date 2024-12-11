<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateCustomsAgentRequest extends FormRequest
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
            "name" => "required|string|max:70",
            "patent" => "required|string|max:10",
            "status_id" => "required|exists:statuses,id",
        ];
    }

    public function messages(){
        return [
            "name.required" => "El campo razon social es obligatorio",
            "name.max" => "El campo razon social excede la longitud de caracteres permitidos, maximo (70)",
            "patent.required" => "El campo patente es obligatorio",
            "patent.max" => "El campo patente excede la longitud de caracteres permitidos, maximo (10)",
            "status_id.required" => "El campo estatus es obligatorio",
            "status_id.exists" => "El valor ingresado no es permitido",
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
