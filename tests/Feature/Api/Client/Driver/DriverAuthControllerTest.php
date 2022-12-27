<?php

namespace Tests\Feature\Api\Client\Driver;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriverAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function it_should_be_able_to_register_a_new_driver()
    {
        //Arrange

        //Act
        $response = $this->post('api/client/driver/auth/register', [
             'name'          => fake()->name(),
             'email'         => fake()->email(),
             'phone'         => fake()->phoneNumber(),
             'licence_plate' => fake()->randomNumber(),
             'vehicle_type'  => 'Carro',
             'zipcode'       => fake()->postcode(),
         ]);

        //Assert
        $response->assertSuccessful();
    }
}
