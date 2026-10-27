<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        DB::table('reservations')->insert([
            'nom' => 'Test Client',
            'email' => 'test@example.com',
            'telephone' => '0600000000',
            'type_vehicule' => 'voiture',
            'date_reservation' => '2025-09-25',
            'heure_reservation' => '10:00:00',
            'type_lavage' => 'Lavage Premium',
            'remarque' => 'Réservation de test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}