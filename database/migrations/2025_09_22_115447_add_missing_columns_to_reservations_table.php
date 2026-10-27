<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMissingColumnsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Rendre les colonnes nullable pour éviter l'erreur
            if (!Schema::hasColumn('reservations', 'type_vehicule')) {
                $table->string('type_vehicule')->nullable()->after('telephone');
            }
            if (!Schema::hasColumn('reservations', 'type_lavage')) {
                $table->string('type_lavage')->nullable()->after('type_vehicule');
            }
            if (!Schema::hasColumn('reservations', 'date_reservation')) {
                $table->date('date_reservation')->nullable()->after('type_lavage'); // ← nullable
            }
            if (!Schema::hasColumn('reservations', 'heure_reservation')) {
                $table->string('heure_reservation')->nullable()->after('date_reservation'); // ← nullable
            }
        });

        // Mettre à jour les enregistrements existants avec des valeurs par défaut
        DB::table('reservations')->whereNull('date_reservation')->update([
            'date_reservation' => '2024-01-01', // Date par défaut
            'heure_reservation' => '12:00', // Heure par défaut
            'type_vehicule' => 'voiture', // Valeur par défaut
            'type_lavage' => 'Lavage basique' // Valeur par défaut
        ]);

        // Maintenant, vous pouvez rendre les colonnes required si nécessaire
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('type_vehicule')->nullable(false)->change();
            $table->string('type_lavage')->nullable(false)->change();
            $table->date('date_reservation')->nullable(false)->change();
            $table->string('heure_reservation')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['type_vehicule', 'type_lavage', 'date_reservation', 'heure_reservation']);
        });
    }
}