<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,name',
            'status_id' => 'required|exists:statuses,id',
            'password' => 'required|string|min:8|confirmed',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'second_lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'branch_id' => 'required|integer|exists:branches,id',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El campo usuario es obligatorio.',
            'username.string' => 'El usuario debe ser una cadena de texto.',
            'username.max' => 'El usuario no puede exceder los 255 caracteres.',
            'username.unique' => 'El usuario ingresado ya esta registrado',
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
            'status.exists' => 'Estado seleccionado no es válido.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Ambas contraseñas ingresadas no coinciden',
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
