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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('type_vehicule');
            $table->string('type_lavage');
            $table->decimal('prix', 8, 2);
            $table->string('marque');
            $table->string('matricule');
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->boolean('est_societe')->default(false);
            $table->foreignId('societe_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date_prestation');
            $table->text('remarque')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
