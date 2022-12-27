<?php

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\User\UserType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create(['name' => 'Admin']);

        User::firstOrCreate([
            'name'         => 'Admin',
            'user_type_id' => 1,
            'email'        => 'admin@redefrete.com.br',
            'password'     => 'password', // password
        ]);
    }
}
