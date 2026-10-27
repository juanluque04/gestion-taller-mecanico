<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tareas', function (Blueprint $table) {

            if (!Schema::hasColumn('tareas', 'FechaProgramada')) {
                $table->date('FechaProgramada')->nullable()->after('Prioridad');
            }

            if (!Schema::hasColumn('tareas', 'FechaRealizada')) {
                $table->date('FechaRealizada')->nullable()->after('FechaProgramada');
            }
        });
    }

    public function down()
    {
        Schema::table('tareas', function (Blueprint $table) {

            if (Schema::hasColumn('tareas', 'FechaProgramada')) {
                $table->dropColumn('FechaProgramada');
            }

            if (Schema::hasColumn('tareas', 'FechaRealizada')) {
                $table->dropColumn('FechaRealizada');
            }
        });
    }


};
