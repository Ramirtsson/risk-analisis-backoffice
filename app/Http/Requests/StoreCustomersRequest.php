<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_type' => 'required|exists:client_types,id',
            'social_reason' => 'required|string|max:70',
            'tax_domicile' => 'required|string|max:100',
            'tax_id' => 'required|string|max:25',
            'phone_1' => 'nullable|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'mail_1' => 'nullable|email|max:50',
            'mail_2' => 'nullable|email|max:50',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
        ];
    }


    public function messages(): array
    {
        return [
            'customer_type.required' => 'Tipo de cliente obligatorio.',
            'customer_type.exists' => 'Tipo de cliente seleccionado no es válido.',
            'social_reason.required' => 'Razón social obligatoria.',
            'social_reason.max' => 'Razón social no puede tener más de 70 caracteres.',
            'tax_domicile.required' => 'Domicilio fiscal obligatorio.',
            'tax_domicile.max' => 'Domicilio fiscal no puede tener más de 100 caracteres.',
            'tax_id.required' => 'RFC obligatorio.',
            'tax_id.max' => 'RFC no puede tener más de 25 caracteres.',
            'phone_1.max' => 'Teléfono 1 no puede tener más de 15 caracteres.',
            'phone_2.max' => 'Teléfono 2 no puede tener más de 15 caracteres.',
            'mail_1.email' => 'Correo 1 debe ser una dirección de correo válida.',
            'mail_1.max' => 'Correo 1 no puede tener más de 50 caracteres.',
            'mail_2.email' => 'Correo 2 debe ser una dirección de correo válida.',
            'mail_2.max' => 'Correo 2 no puede tener más de 50 caracteres.',
            'status_id.required' => 'Estado obligatorio.',
            'status_id.exists' => 'Estado seleccionado no es válido.',
            'user_id.required' => 'ID de usuario obligatorio.',
            'user_id.exists' => 'ID de usuario seleccionado no es válido.',
        ];
    }

}
