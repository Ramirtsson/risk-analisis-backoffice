<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreSupplierRequest extends FormRequest
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
            "name" => "required|string|max:255",
            "code" => "required|string|max:100",
            "rfc" => "required|string|max:255",
            "address" => "required|string|max:255",
            "city" => "required|string|max:255",
            "zip_code" => "required|string|max:15",
            "country_id" => "required|exists:countries,id",
            "status_id" => "required|exists:statuses,id",
        ];
    }

    public function messages(){
        return [
            "name.required" => "El campo nombre es obligatorio",
            "name.max" => "El campo nombre excede la longitud de caracteres permitidos, maximo (255)",
            "code.required" => "El campo codigo es obligatorio",
            "code.max" => "El campo codigo excede la longitud de caracteres permitidos, maximo (100)",
            "rfc.required" => "El campo RFC es obligatorio",
            "rfc.max" => "El campo RFC excede la longitud de caracteres permitidos, maximo (255)",
            "address.required" => "El campo direccion es obligatorio",
            "address.max" => "El campo direccion excede la longitud de caracteres permitidos, maximo (255)",
            "city.required" => "El campo ciudad es obligatorio",
            "city.max" => "El campo ciudad excede la longitud de caracteres permitidos, maximo (255)",
            "zip_code.required" => "El campo codigo postal es obligatorio",
            "zip_code.exists" => "El campo codigo postal excede la longitud de caracteres permitidos, maximo (15)",
            "country_id.required" => "El campo pais es obligatorio",
            "country_id.exists" => "El valor ingresado no es permitido",
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
