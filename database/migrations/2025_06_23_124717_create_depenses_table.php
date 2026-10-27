<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // ex: "carburant", "produit", "entretien", "autre"
            $table->string('autre_type')->nullable(); // utilisé uniquement si type = "autre"
            $table->decimal('montant', 8, 2);
            $table->date('date');
            $table->text('remarque')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
