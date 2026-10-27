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
        Schema::create('tareas', function (Blueprint $table){
            
            $table->id('id_Tarea');

            $table->text('Descripcion');
            $table->enum('Estado', ['pendiente','en curso','terminada','revisada']);
            $table->enum('Prioridad', ['alta','media','baja']);
            $table->unsignedBigInteger('id_Reparacion');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('id_Reparacion')->references('id_Reparacion')->on('reparaciones')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
