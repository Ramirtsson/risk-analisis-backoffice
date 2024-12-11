<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateBranchRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status_id' => 'required|exists:App\Models\Branch,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Campo nombre de sucursal es obligatorio.',
            'address.required' => 'Campo dirección es obligatorio.',
            'status.required' => 'Campo estado es obligatorio.',
            'status.exists' => 'Campo estado no existe.'
        ];
    }
}
