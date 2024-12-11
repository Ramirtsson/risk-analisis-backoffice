<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    private array $itemsValid = [
        'name' => 'required',
        'status_id' => 'required|exists:statuses,id',
    ];
    private array $messageValid = [
        'name.required' => 'Campo Nombre es obligatorio',
        'status_id.required' => 'Campo Estatus es obligatorio',
    ];
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
        if ($this->isMethod('put')) {
            unset($this->itemsValid['name']);
            unset($this->itemsValid['status_id']);
            $this->itemsValid['nameEdit'] = 'required';
            $this->itemsValid['status_idEdit'] = 'required|exists:statuses,id';
        }

        return $this->itemsValid;
    }

    public function messages(): array
    {
        if ($this->isMethod('put')) {
            unset($this->itemsValid['name.required']);
            unset($this->itemsValid['status_id.required']);
            $this->itemsValid['nameEdit.required'] = 'Campo Nombre es obligatorio';
            $this->itemsValid['status_idEdit.required'] = 'Campo Estatus es obligatorio';
        }
        return $this->messageValid;
    }
}
