<?php

namespace Database\Factories\Vehicle;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid'            => Str::uuid(),
            'vehicle_type_id' => mt_rand(1, 3),
            // 'driver_bank_id',
            'status'         => 1,
            'brand'          => strtoupper(fake()->word()),
            'model'          => ucfirst(fake()->word()),
            'uf'             => 'SP',
            'licence_plate'  => strtoupper(Str::random(7)),
            'licence_number' => mt_rand(11111111, 99999999),
            'owner_document' => mt_rand(11111111, 99999999),
            'owner_type'     => 'PF',
            'owner_name'     => fake()->name,
            'owner_phone'    => fake()->phone,
        ];
    }
}
