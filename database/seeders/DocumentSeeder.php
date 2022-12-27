<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            'CPF',
            'RG',
            'CNPJ',
            'CNH',
            'ENDEREÇO',
        ];

        collect($documents)->map(fn ($x) => Document::firstOrCreate(['name' => $x, 'slug' => Str::slug($x)]));
    }
}
