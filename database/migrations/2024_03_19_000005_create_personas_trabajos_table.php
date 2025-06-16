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
        Schema::create('personas_trabajos', function (Blueprint $table) {
            $table->id('idperstrabajo');
            $table->integer('idpersona');
            $table->string('empresa', 100);
            $table->string('cargo', 100);
            $table->date('fechainicio');
            $table->date('fechafin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas_trabajos');
    }
}; 