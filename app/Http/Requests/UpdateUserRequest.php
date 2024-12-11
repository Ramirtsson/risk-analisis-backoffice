<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users,name,'. $this->user->id,
            'status_id' => 'required|exists:statuses,id',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'second_lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email,'. $this->user->profile->id,
            'branch_id' => 'required|integer|exists:branches,id',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'El campo usuario es obligatorio.',
            'user.string' => 'El usuario debe ser una cadena de texto.',
            'user.max' => 'El usuario no puede exceder los 255 caracteres.',
            'user.unique' => 'El usuario ingresado ya esta registrado',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'lastname.required' => 'El campo apellido paterno es obligatorio.',
            'lastname.string' => 'El apellido paterno debe ser una cadena de texto.',
            'lastname.max' => 'El apellido paterno no puede exceder los 255 caracteres.',
            'second_lastname.required' => 'El campo apellido materno es obligatorio.',
            'second_lastname.string' => 'El apellido materno debe ser una cadena de texto.',
            'second_lastname.max' => 'El apellido materno no puede exceder los 255 caracteres.',
            'status.required' => 'El campo estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'email.required' => 'El campo correo electronico es obligatorio.',
            'email.email' => 'El formato del correo ingresado no es correcto.',
            'email.unique' => 'El correo ingresado ya esta registrado.',
            'branch_id.required' => 'El campo sucursal es obligatorio.',
            'branch_id.integer' => 'El campo sucursal debe ser de formato integer.',
            'branch_id.exists' => 'El sucursal no existe.',
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
