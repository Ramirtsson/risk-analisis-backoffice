<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitMeasuresRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|max:100|string",
            "code" => "required|max:5",
            "prefix" => "nullable|max:3",
            "status_id" => "required|exists:statuses,id"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Campo unidad de medida es obligatorio.",
            "name.string" => "Unidad de medida debe de ser una cadena de caracteres.",
            "name.max" => "Unidad de medida no puede exceder los 100 caracteres.",
            "code.required" => "Código es obligatorio.",
            "code.max" => "Campo código no puede exceder los 5 caracteres.",
            "prefix.required" => "Prefijo de la unidad de medida es obligatorio.",
            "prefix.max" => "Campo Prefijo no puede exceder los 3 caracteres.",
            "status_id.required" => "Estado de la unidad de medida es requerido.",
            "status_id.exists" => "Estado no existe en base de datos."
        ];
    }
}
