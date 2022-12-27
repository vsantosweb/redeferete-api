<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Driver\Driver;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DocumentSeeder::class,
            UserSeeder::class,
            DriverStatusSeeder::class,
            VehicleTypeSeeder::class,
            DriverLicenceCategorySeeder::class,
            CompanySeeder::class,
            RiskManangerSeeder::class,
            SystemSettingSeeder::class,
            DriverSeeder::class,
            DriverPartnerSeeder::class,
            // DriverContractSeeder::class
        ]);

        // Driver::factory(6)->create();
    }
}
