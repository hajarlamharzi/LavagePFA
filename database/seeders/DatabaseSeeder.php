<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TarifSeeder::class,
            EmployeSeeder::class,
            UserSeeder::class,
        ]);

        User::firstOrCreate(
            ['nom' => 'admin'],
            [
                'password' => Hash::make('adminpass'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['nom' => 'employe'],
            [
                'password' => Hash::make('employepass'),
                'role' => 'employe',
            ]
        );
        $this->call([
        ReservationSeeder::class,
    ]);
    }
}
