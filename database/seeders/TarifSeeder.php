<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = [
            'petite_voiture' => [
                'express' => 30,
                'complet' => 50,
                'interieur' => 40,
                'special' => 60,
                'extra' => 70,
                'moteur' => 35,
            ],
            'suv' => [
                'express' => 40,
                'complet' => 60,
                'interieur' => 50,
                'special' => 70,
                'extra' => 80,
                'moteur' => 45,
            ],
            'van' => [
                'express' => 45,
                'complet' => 70,
                'interieur' => 60,
                'special' => 75,
                'extra' => 90,
                'moteur' => 50,
            ],
            'berline' => [
                'express' => 35,
                'complet' => 55,
                'interieur' => 45,
                'special' => 65,
                'extra' => 75,
                'moteur' => 40,
            ],
            'voiture_de_service' => [
                'express' => 38,
                'complet' => 58,
                'interieur' => 48,
                'special' => 68,
                'extra' => 78,
                'moteur' => 43,
            ],
            'moto' => [
                'moto' => 25, // seul type autorisé pour moto
            ],
        ];

        foreach ($vehicules as $typeVehicule => $lavages) {
            foreach ($lavages as $typeLavage => $prix) {
                Tarif::updateOrCreate([
                    'type_vehicule' => $typeVehicule,
                    'type_lavage' => $typeLavage,
                ], [
                    'prix' => $prix,
                ]);
            }
        }
    }
}

