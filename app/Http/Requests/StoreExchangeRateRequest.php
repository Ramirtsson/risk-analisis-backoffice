<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExchangeRateRequest extends FormRequest
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
            'exchange' => 'required|numeric',
            'date' => 'required|date',
            'status_id' => 'required|exists:statuses,id',
        ];
    }
    public function messages(): array
    {
        return [
            'exchange.required' => 'Campo tipo de cambio es obligatorio.',
            'exchange.numeric' => 'El tipo de cambio debe ser un número válido.',
            'date.required' => 'Campo fecha es obligatorio.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
            'status.required' => 'Campo estado es obligatorio.',
            'status.exists' => 'Campo estado no existe.'
        ];
    }

}
