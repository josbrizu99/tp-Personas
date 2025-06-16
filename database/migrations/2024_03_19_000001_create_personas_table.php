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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('idpersona');
            $table->string('nrodocpersona', 20);
            $table->string('rucpersona', 15)->nullable();
            $table->string('nom_persona', 100);
            $table->string('ape_persona', 100);
            $table->string('nombrepersona', 200);
            $table->string('direccionpersona', 150);
            $table->date('fechanacpersona');
            $table->integer('idtppersona');
            $table->dateTime('fechaingpersona');
            $table->integer('idtpidentificacion');
            $table->integer('idnaturaleza');
            $table->integer('idsexo');
            $table->integer('idnacionalidad');
            $table->integer('idestadocivil');
            $table->integer('idocupacion');
            $table->integer('idprofesion');
            $table->integer('idciudadnacimiento');
            $table->string('emailpersona', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
}; 