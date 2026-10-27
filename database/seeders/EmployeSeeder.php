<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;

class EmployeSeeder extends Seeder
{
    public function run(): void
    {
        $employes = [
            ['nom' => 'El Amrani', 'prenom' => 'Youssef', 'cin' => 'AB123456'],
            ['nom' => 'Bennani', 'prenom' => 'Fatima', 'cin' => 'CD789012'],
            ['nom' => 'Nouiri', 'prenom' => 'Karim', 'cin' => 'EF345678'],
            ['nom' => 'Lahmidi', 'prenom' => 'Sara', 'cin' => 'GH901234'],
        ];

        foreach ($employes as $employe) {
            Employe::create($employe);
        }
    }
}
