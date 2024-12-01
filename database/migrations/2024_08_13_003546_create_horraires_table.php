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
        Schema::create('horraires', function (Blueprint $table) {
            $table->id();
            $table->string('horraire');
            $table->time('start_time')->nullable(); // Heure de début
            $table->time('end_time')->nullable();   // Heure de fin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horraires');
    }
};
