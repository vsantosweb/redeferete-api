<?php

namespace Database\Factories\Driver;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver\DriverBank>
 */
class DriverBankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'document'    => mt_rand(11111111111, 99999999999),
            'name'        => fake()->name,
            'status'      => 1,
            'type'        => 'Conta corrente',
            'code'        => time(),
            'bank_name'   => fake()->word(),
            'bank_agency' => mt_rand(1111, 9999),
            'bank_number' => mt_rand(111111, 999999),
            'bank_digit'  => mt_rand(1, 9),
        ];
    }
}
