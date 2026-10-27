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
        Schema::create('materiales', function (Blueprint $table){
            
            $table->id('id_Material');

            $table->text('Descripcion');
            $table->integer('Cantidad'); 
            $table->enum('Estado',['pedido','recibido','usado']);
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
        Schema::dropIfExists('materiales');
    }
};
