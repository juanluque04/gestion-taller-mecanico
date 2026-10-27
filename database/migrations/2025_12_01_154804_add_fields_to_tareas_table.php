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

            $table->date('FechaRealizada')->nullable()->after('Estado');
            $table->decimal('HorasPrevistas', 5,2)->nullable()->after('FechaRealizada');
            $table->decimal('HorasReales', 5,2)->nullable()->after('HorasPrevistas');
            $table->decimal('Importe', 8,2)->nullable()->after('HorasReales');
            $table->text('Observaciones')->nullable()->after('Importe');

        });
    }

    public function down()
    {
        Schema::table('tareas', function (Blueprint $table) {

            $table->dropColumn([
                'FechaRealizada',
                'HorasPrevistas',
                'HorasReales',
                'Importe',
                'Observaciones',
            ]);

        });
    }

};
