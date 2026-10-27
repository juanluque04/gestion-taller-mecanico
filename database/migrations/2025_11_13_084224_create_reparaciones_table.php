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
        Schema::create('reparaciones', function (Blueprint $table){
            
            $table->id('id_Reparacion');

            $table->date('FechaEntrada');
            $table->date('FechaSalida')->nullable();
            $table->enum('Estado',['pendiente','en curso','terminada','cancelada']);  
            $table->text('Observaciones')->nullable(); 
            $table->unsignedBigInteger('id_Vehiculo');

            $table->foreign('id_Vehiculo')->references('id_Vehiculo')->on('vehiculos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};
