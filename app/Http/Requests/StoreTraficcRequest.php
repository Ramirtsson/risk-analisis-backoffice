<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTraficcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'status_id' => 'required|exists:statuses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nombre del tráfico es requerido.',
            'name.string' => 'Nombre del tráfico debe ser una cadena.',
            'name.max' => 'Nombre del tráfico no debe tener más de 30 caracteres.',
            'status.required' => 'Estado del tráfico es requerido.',
            'status_id.exists' => 'Estado no existe en base de datos.'
        ];
    }
}
