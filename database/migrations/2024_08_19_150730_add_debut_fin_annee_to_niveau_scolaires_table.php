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
        Schema::table('niveau_scolaires', function (Blueprint $table) {
            $table->integer('debut_annee')->nullable(); // Ajoute la colonne debut_annee
            $table->integer('fin_annee')->nullable();   // Ajoute la colonne fin_annee
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('niveau_scolaires', function (Blueprint $table) {
            $table->dropColumn('debut_annee');
            $table->dropColumn('fin_annee');
        });
    }
};
