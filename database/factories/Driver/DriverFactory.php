<?php

namespace Database\Factories\Driver;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $document = mt_rand(11111111111, 99999999999999);

        return [
            'name'              => fake()->unique()->name,
            'driver_status_id'  => mt_rand(1, 5),
            'email'             => fake()->unique()->safeEmail,
            'email_verified_at' => now(),
            'document_1'        => $document,
            'type'              => strlen((string) $document) > 11 ? 'PJ' : 'PF',
            'password'          => 'password', // password
            'phone'             => str_replace(['(', ')', '-', ' ', '+'], '', fake()->phoneNumber()),
            'home_dir'          => 'drivers/' . Str::uuid(),
            'ip'                => fake()->ipv4(),
            'user_agent'        => fake()->userAgent(),
            'created_at'        => fake()->dateTimeBetween('-90 days', 'now'),
        ];
    }
}
