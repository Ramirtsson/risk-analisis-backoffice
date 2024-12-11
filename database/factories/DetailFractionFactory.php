<?php

namespace Database\Factories;

use App\Models\Fraction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailFraction>
 */
class DetailFractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'fraction_id' => Fraction::factory(),
            'status_id' => 1,
            'user_id' => 1,
        ];
    }
}
