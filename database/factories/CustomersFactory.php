<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customers;

class CustomersFactory extends Factory
{
    protected $model = Customers::class;

    public function definition(): array
    {
        return [
            'customer_type' => $this->faker->numberBetween(1, 2),
            'social_reason' => $this->faker->company,
            'tax_domicile' => $this->faker->address,
            'tax_id' => $this->faker->unique()->numerify('###########'),
            'phone_1' => $this->faker->regexify('\+1 \(\d{3}\) \d{3}-\d{4}'),
            'phone_2' => $this->faker->regexify('\+1 \(\d{3}\) \d{3}-\d{4}'),
            'mail_1' => $this->faker->safeEmail,
            'mail_2' => $this->faker->safeEmail,
            'user_id' => 1,
            'status_id' => 1, 
        ];
        
    }
}
