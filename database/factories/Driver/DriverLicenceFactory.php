<?php

namespace Database\Factories\Driver;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver\DriverLicence>
 */
class DriverLicenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'driver_licence_category_id' => mt_rand(1, 9),
            'document_number'            => mt_rand(111111111, 999999999),
            'security_code'              => mt_rand(1111111, 9999999),
            'expire_at'                  => now()->addYear(mt_rand(1, 3)),
            'uf'                         => 'SP',
            'first_licence_date'         => now()->subYear(mt_rand(2, 10)),
            'mother_name'                => fake()->name,
        ];
    }
}
