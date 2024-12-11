<?php

namespace Database\Factories;
use App\Models\Consignee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Consignee>
 */
class ConsigneeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rfc' => strtoupper(Str::random(13)),
            'curp' => strtoupper(Str::random(13)),
            'address' => strtoupper(Str::random(13)),
            'city' => $this->faker->city(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'zip_code' => $this->faker->postcode(),
            'state' => strtoupper(Str::random(6)),
            'user_id' => 1,
            'status_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
