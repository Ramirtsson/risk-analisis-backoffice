<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManifestRequest extends FormRequest
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
            "import_request" => 'required',
            "arrival_date" => 'required|date',
            "modulation_date" => 'required|date',
            "number_guide" => "required",
            "house_guide" => 'required',
            "lumps" => 'required',
            "gross_weight" => 'required',
            "packages" => 'required',
            "registration_number" => 'required',
            "invoice" => 'required',
            "invoice_date" => 'required|date',
            "total_invoice" => 'required|string',
            "transmission_date" => 'required|date',
            "payment_date" => 'required|date',
            "customer_id" => 'required|exists:customers,id',
            "custom_agent_id" => 'required|exists:customs_agents,id',
            "custom_house_id" => 'required|exists:custom_houses,id',
            "courier_company_id" => 'required|exists:courier_companies,id',
            "supplier_id" => 'required|exists:suppliers,id',
            "traffic_id" => 'required|exists:traficcs,id',
            "value_id" => 'required|exists:value_types,id',
            "exchange_rate_id" => 'required|exists:exchange_rates,id',
            "currency_id" => 'required|exists:currencies,id',
            "warehouse_office_id" => 'required|exists:warehouse_offices,id',
            "warehouse_origin_id" => 'required|exists:warehouses_origin,id',
            "operating_status_id" => 'required|exists:operating_statuses,id',
            "status_id" => 'required|exists:statuses,id',
        ];
    }

    public function messages():array
    {
        return [

            "import_request.required" => 'Campo obligatorio',
            "arrival_date.required" => 'Campo obligatorio',
            "arrival_date.date" => 'Fecha invalida',
            "modulation_date.required" => 'Campo obligatorio',
            "modulation_date.date" => 'Fecha invalida',
            "number_guide.required" => "Campo obligatorio",
            "house_guide.required" => 'Campo obligatorio',
            "lumps.required" => 'Campo obligatorio',
            "gross_weight.required" => 'Campo obligatorio',
            "packages.required" => 'Campo obligatorio',
            "registration_number.required" => 'Campo obligatorio',
            "invoice.required" => 'Campo obligatorio',
            "invoice_date.required" => 'Campo obligatorio',
            "invoice_date.date" => 'Fecha invalida',
            "total_invoice.required" => 'Campo obligatorio',
            "transmission_date.required" => 'Campo obligatorio',
            "transmission_date.date" => 'Fecha invalida',
            "payment_date.required" => 'Campo obligatorio',
            "payment_date.date" => 'Fecha invalida',
            "customer_id.required" => 'Campo obligatorio',
            "customer_id.exists" => 'Campo invalido',
            "custom_agent_id.required" => 'Campo obligatorio',
            "custom_agent_id.exists" => 'Campo invalido',
            "custom_house_id.required" => 'Campo obligatorio',
            "custom_house_id.exits" => 'Campo invalido',
            "courier_company_id.required" => 'Campo obligatorio',
            "courier_company_id.exists" => 'Campo invalido',
            "supplier_id.required" => 'Campo obligatorio',
            "supplier_id.exists" => 'Campo invalido',
            "traffic_id.required" => 'Campo obligatorio',
            "traffic_id.exists" => 'Campo invalido',
            "value_id.required" => 'Campo obligatorio',
            "value_id.exists" => 'Campo invalido',
            "exchange_rate_id.required" => 'Campo obligatorio',
            "exchange_rate_id.exists" => 'Campo invalido',
            "currency_id.required" => 'Campo obligatorio',
            "currency_id.exists" => 'Campo invalido',
            "warehouse_office_id.required" => 'Campo obligatorio',
            "warehouse_office_id.exists" => 'Campo invalido',
            "warehouse_origin_id.required" => 'Campo obligatorio',
            "warehouse_origin_id.exists" => 'Campo invalido',
            "operating_status_id.required" => 'Campo obligatorio',
            "operating_status_id.exists" => 'Campo invalido',
            "status_id.required" => 'Campo obligatorio',
            "status_id.exists" => 'Campo invalido'
        ];
    }
}
