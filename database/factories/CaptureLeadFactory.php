<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CaptureLeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name,
            'email'         => $this->faker->email,
            'phone'         => $this->faker->phoneNumber(),
            'licence_plate' => Str::random(8),
            'vehicle_type'  => $this->faker->lastName(),
            'zipcode'       => $this->faker->postcode(),
        ];
    }
}
