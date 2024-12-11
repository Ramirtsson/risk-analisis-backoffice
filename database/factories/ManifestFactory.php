<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manifest>
 */
class ManifestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "import_request" => $this->faker->text(10),
            "arrival_date" => $this->faker->date('Y-m-d'),
            "modulation_date" => $this->faker->date('Y-m-d'),
            "number_guide" => $this->faker->text(10),
            "house_guide" => $this->faker->text(50),
            "lumps" => 12.345,
            "gross_weight" => 654.2,
            "packages" => rand(10, 100),
            "registration_number" => rand(10, 100),
            "invoice" => $this->faker->text(10),
            "invoice_date" => $this->faker->date('Y-m-d'),
            "rectified" => $this->faker->boolean(),
            "total_invoice" => 123.458,
            "transmission_date" => $this->faker->date('Y-m-d'),
            "payment_date" => $this->faker->date('Y-m-d'),
            "manifest_file" => $this->faker->text(20),
            "checked" => $this->faker->boolean(),
            "customer_id" => 2,
            "custom_agent_id" => 1,
            "custom_house_id" => 1,
            "courier_company_id" => 1,
            "supplier_id" => 1,
            "traffic_id" => 1,
            "value_id" => 1,
            "exchange_rate_id" => 1,
            "currency_id" => 1,
            "warehouse_office_id" => 1,
            "warehouse_origin_id" => 1,
            "operating_status_id" => 1,
            "user_id" => 1,
            "status_id" => 1,
        ];
    }
}
