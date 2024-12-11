<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateManifestRequest extends FormRequest
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
        $rules = [
            "manifest" => 'required|array',
            "manifest.*.import_request" => 'required',
            "manifest.*.arrival_date" => 'required|date',
            "manifest.*.modulation_date" => 'required|date',
            "manifest.*.number_guide" => "required",
            "manifest.*.house_guide" => 'required',
            "manifest.*.lumps" => 'required',
            "manifest.*.gross_weight" => 'required',
            "manifest.*.packages" => 'required',
            "manifest.*.registration_number" => 'required',
            "manifest.*.invoice" => 'required',
            "manifest.*.invoice_date" => 'required|date',
            "manifest.*.rectified" => 'required|in:0,1',
            "manifest.*.total_invoice" => 'required|string',
            "manifest.*.transmission_date" => 'required|date',
            "manifest.*.customer_id" => 'required|exists:customers,id',
            "manifest.*.custom_agent_id" => 'required|exists:customs_agents,id',
            "manifest.*.custom_house_id" => 'required|exists:custom_houses,id',
            "manifest.*.courier_company_id" => 'required|exists:courier_companies,id',
            "manifest.*.supplier_id" => 'required|exists:suppliers,id',
            "manifest.*.traffic_id" => 'required|exists:traficcs,id',
            "manifest.*.value_id" => 'required|exists:value_types,id',
            "manifest.*.exchange_rate_id" => 'required|exists:exchange_rates,id',
            "manifest.*.currency_id" => 'required|exists:currencies,id',
            "manifest.*.warehouse_office_id" => 'required|exists:warehouse_offices,id',
            "manifest.*.warehouse_origin_id" => 'required|exists:warehouses_origin,id',
            "rectified" =>'required|integer',
            "rectifiedManifest" => 'required_if:rectified,1|array',
            "rectifiedManifest.*.number_rectified" => 'required_if:rectified,1',
            "rectifiedManifest.*.r_payment_date" => 'required_if:rectified,1|date',
            "rectifiedManifest.*.r_modulation_date" => 'required_if:rectified,1|date',
            "rectifiedManifest.*.status_id" => 'required_if:rectified,1'
        ];
    
        return $rules;
    }

    public function messages():array
    {
        return [
            "manifest.required"=>"Campo obligatorio",
            "manifest.array"=>"Campo invalido",
            "manifest.*.import_request.required" => 'Campo obligatorio',
            "manifest.*.arrival_date.required" => 'Campo obligatorio',
            "manifest.*.arrival_date.date" => 'Fecha invalida',
            "manifest.*.modulation_date.required" => 'Campo obligatorio',
            "manifest.*.modulation_date.date" => 'Fecha invalida',
            "manifest.*.number_guide.required" => "Campo obligatorio",
            "manifest.*.house_guide.required" => 'Campo obligatorio',
            "manifest.*.lumps.required" => 'Campo obligatorio',
            "manifest.*.gross_weight.required" => 'Campo obligatorio',
            "manifest.*.packages.required" => 'Campo obligatorio',
            "manifest.*.registration_number.required" => 'Campo obligatorio',
            "manifest.*.invoice.required" => 'Campo obligatorio',
            "manifest.*.invoice_date.required" => 'Campo obligatorio',
            "manifest.*.invoice_date.date" => 'Fecha invalida',
            "manifest.*.total_invoice.required" => 'Campo obligatorio',
            "manifest.*.transmission_date.required" => 'Campo obligatorio',
            "manifest.*.transmission_date.date" => 'Fecha invalida',
            "manifest.*.customer_id.required" => 'Campo obligatorio',
            "manifest.*.customer_id.exists" => 'Campo invalido',
            "manifest.*.custom_agent_id.required" => 'Campo obligatorio',
            "manifest.*.custom_agent_id.exists" => 'Campo invalido',
            "manifest.*.custom_house_id.required" => 'Campo obligatorio',
            "manifest.*.custom_house_id.exits" => 'Campo invalido',
            "manifest.*.courier_company_id.required" => 'Campo obligatorio',
            "manifest.*.courier_company_id.exists" => 'Campo invalido',
            "manifest.*.supplier_id.required" => 'Campo obligatorio',
            "manifest.*.supplier_id.exists" => 'Campo invalido',
            "manifest.*.traffic_id.required" => 'Campo obligatorio',
            "manifest.*.traffic_id.exists" => 'Campo invalido',
            "manifest.*.value_id.required" => 'Campo obligatorio',
            "manifest.*.value_id.exists" => 'Campo invalido',
            "manifest.*.exchange_rate_id.required" => 'Campo obligatorio',
            "manifest.*.exchange_rate_id.exists" => 'Campo invalido',
            "manifest.*.currency_id.required" => 'Campo obligatorio',
            "manifest.*.currency_id.exists" => 'Campo invalido',
            "manifest.*.warehouse_office_id.required" => 'Campo obligatorio',
            "manifest.*.warehouse_office_id.exists" => 'Campo invalido',
            "manifest.*.warehouse_origin_id.required" => 'Campo obligatorio',
            "manifest.*.warehouse_origin_id.exists" => 'Campo invalido',
            "rectified.required" => 'Campo requerido',
            "rectified.integer" => 'Campo invalido',
            "rectifiedManifest.required" => 'Campo requerido',
            "rectifiedManifest.array" => 'Campo invalido',
            "rectifiedManifest.*.number_rectified.required_if" => 'Campo requerido',
            "rectifiedManifest.*.r_payment_date.required_if" => 'Campo requerido',
            "rectifiedManifest.*.r_modulation_date.required_if" => 'Campo requerido',
            "rectifiedManifest.*.status_id.required_if" => 'Campo requerido'
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
