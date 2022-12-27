<?php

namespace Database\Seeders;

use App\Models\Driver\DriverLicenceCategory;
use Illuminate\Database\Seeder;

class DriverLicenceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'AB',
            'AC',
            'AD',
            'AE',
        ];

        collect($categories)->map(fn ($category) => DriverLicenceCategory::updateOrCreate(['name' => $category]));
    }
}
