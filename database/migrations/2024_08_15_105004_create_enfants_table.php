<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_de_naissance');

            // Ajout de la clé étrangère pour le parent
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->foreign('id_parent')
                  ->references('id')
                  ->on('parents')
                  ->onDelete('cascade');

            // Ajout de la clé étrangère pour le niveau scolaire
            $table->unsignedBigInteger('niveau_scolaire_id')->nullable();
            $table->foreign('niveau_scolaire_id')
                  ->references('id')
                  ->on('niveau_scolaires')
                  ->onDelete('set null');

            $table->timestamps();

            Schema::create('horraires', function (Blueprint $table) {
                $table->id();
                $table->string('horraire');
                $table->time('start_time');
                $table->time('end_time');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enfants');
    }
}
