<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemModuleRequest extends FormRequest
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
            'name' => 'required',
            'status_id' => 'required|exists:statuses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo nombre de modulo es obligatorio',
            'status_id.required' => 'Campo nombre estatus es obligatorio',
            'status_id.exists' => 'Campo estado no existe en base de datos',
        ];
    }
}
