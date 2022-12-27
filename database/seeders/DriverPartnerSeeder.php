<?php

namespace Database\Seeders;

use App\Models\Driver\DriverPartner;
use Illuminate\Database\Seeder;

class DriverPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DriverPartner::factory()->count(300)->create();
    }
}
