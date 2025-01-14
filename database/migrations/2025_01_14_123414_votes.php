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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // Relation avec la table utilisateurs
                ->constrained('users')
                ->onDelete('cascade'); // Suppression des votes si l'utilisateur est supprimé
            $table->foreignId('candidat_id') // Relation avec la table candidats
                ->constrained('candidats')
                ->onDelete('cascade'); // Suppression des votes si le candidat est supprimé
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
