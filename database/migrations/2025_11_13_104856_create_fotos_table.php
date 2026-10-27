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
        Schema::create('fotos', function (Blueprint $table){
            
            $table->id('id_Foto');

            $table->string('Url');
            $table->enum('Tipo', ['inicial','final']);
            $table->date('Fecha');
            $table->unsignedBigInteger('id_Tarea');

            $table->foreign('id_Tarea')->references('id_Tarea')->on('tareas')->onDelete('cascade');
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
