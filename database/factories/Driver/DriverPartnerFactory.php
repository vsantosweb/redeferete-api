<?php

namespace Database\Factories\Driver;

use App\Models\Driver\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver\DriverPartner>
 */
class DriverPartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $driverId  = Driver::find(mt_rand(1, Driver::count()));
        $partnerId = Driver::find(mt_rand(1, Driver::count()));

        return [
            'driver_id'  => $driverId->id,
            'partner_id' => $partnerId,
            'vehicle_id' => $driverId->vehicles->random()->id,
            'name'       => $driverId->name,
            'email'      => $driverId->email,
        ];
    }
}
