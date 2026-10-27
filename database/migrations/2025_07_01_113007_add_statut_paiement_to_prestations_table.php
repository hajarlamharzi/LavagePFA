<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('prestations', function (Blueprint $table) {
            $table->string('statut_paiement')->default('non payé');
        });
    }

    public function down()
    {
        Schema::table('prestations', function (Blueprint $table) {
            $table->dropColumn('statut_paiement');
        });
    }

};
