<?php

namespace Database\Factories;

use App\Models\Company\CompanyHub;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreRegistration>
 */
class PreRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hub = CompanyHub::all()->random();

        $avaiable = mt_rand(0, 1);

        return [
            'name'          => $this->faker->name,
            'email'         => $this->faker->email,
            'phone'         => $this->faker->phoneNumber(),
            'licence_plate' => strtoupper(Str::random(8)),
            'vehicle_type'  => $this->faker->lastName(),
            'zipcode'       => $this->faker->postcode(),
            'city'          => $this->faker->city(),
            'hub'           => $avaiable ? $hub->name : 'Indisponível',
            'code'          => $avaiable ? $hub->code : 'Indisponível',
            'company'       => $avaiable ? $hub->company->name : 'Indisponível',
            'is_avaiable'   => mt_rand(0, 1),
            'created_at'    => fake()->dateTimeBetween('-90 days', '+15 days'),
        ];
    }
}
