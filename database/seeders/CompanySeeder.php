<?php

namespace Database\Seeders;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name'  => 'Mercado Livre',
                'label' => 'MELI',
            ],
            [
                'name'  => 'Shopee',
                'label' => 'SHOPEE',
            ],
        ];

        collect($companies)->each(fn ($company) => Company::firstOrCreate($company));
    }
}
