<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['nom' => 'admin'],
            [
                'mot_de_passe' => Hash::make('123'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['nom' => 'employe'],
            [
                'mot_de_passe' => Hash::make('123'),
                'role' => 'employe'
            ]
        );
    }
}
