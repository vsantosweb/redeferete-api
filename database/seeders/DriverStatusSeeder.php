<?php

namespace Database\Seeders;

use App\Models\Driver\DriverStatus;
use Illuminate\Database\Seeder;

class DriverStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Ativo', 'Pendente de Aprovação', 'Em Análise',  'Desativado', 'Capturado'];

        collect($status)->map(fn ($x) => DriverStatus::updateOrCreate(['name' => $x]));
    }
}
