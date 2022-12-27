<?php

namespace Database\Seeders;

use App\Models\Vehicle\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Caminhão', 'Passeio', 'Caminhonete'])->map(fn ($type) => VehicleType::firstOrCreate(['name' => $type]));
    }
}
