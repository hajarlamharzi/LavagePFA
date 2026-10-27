<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('reservations', function (Blueprint $table) {
        // S'assurer que toutes les colonnes existent et ne sont pas nullable
        $table->string('type_vehicule')->nullable(false)->change();
        $table->string('type_lavage')->nullable(false)->change();
        $table->date('date_reservation')->nullable(false)->change();
        $table->string('heure_reservation')->nullable(false)->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
