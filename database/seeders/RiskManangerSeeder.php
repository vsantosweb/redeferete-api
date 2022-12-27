<?php

namespace Database\Seeders;

use App\Models\RiskManager\RiskManager;
use Illuminate\Database\Seeder;

class RiskManangerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $riskManangers = [
            [
                'name'       => 'GUEP',
                'model_name' => 'GuepService',
                'default'    => true,
            ],
            [
                'name'       => 'Telerisco',
                'model_name' => 'TeleriscoService',
            ],
        ];

        collect($riskManangers)->each(fn ($riskMananger) => RiskManager::firstOrCreate($riskMananger));
    }
}
