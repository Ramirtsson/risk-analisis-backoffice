<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateExceptionRequest extends FormRequest
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
            "code_id" => "required|exists:kasa_system_keys,id",
            "complement1" => "required",
            "complement2" => "required|string",
            "complement3" => "required|string",
            "status_id" => "required|exists:statuses,id",
        ];
    }

    public function messages(){
        return [
            "name.required" => "Campo nombre es obligatorio",
            "name.max" => "Campo nombre excede la longitud de caracteres permitidos, máximo (255)",
            "code_id.required" => "Campo codigo es obligatorio",
            "code_id.exists" => "Campo codigo no existe",
            "complement1.required" => "Campo codigo es obligatorio",
            "complement2.required" => "Campo complemento 2 es obligatorio",
            "complement3.required" => "Campo complemento 3 es obligatorio",
            "status_id.required" => "Campo estado es obligatorio",
            "status_id.exists" => "Campo estado no es valido",
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
