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
        Schema::table('vehiculos', function (Blueprint $table) {

            $table->string('Version')->nullable()->after('Modelo');
            $table->string('Bastidor')->nullable()->after('Version');
            $table->string('NumeroMotor')->nullable()->after('Bastidor');
            $table->string('TipoMotor')->nullable()->after('NumeroMotor');
            $table->string('Cilindrada')->nullable()->after('TipoMotor');
            $table->string('Potencia')->nullable()->after('Cilindrada');
            $table->integer('Kilometros')->nullable()->after('Potencia');

        });
    }

    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {

            $table->dropColumn([
                'Version',
                'Bastidor',
                'NumeroMotor',
                'TipoMotor',
                'Cilindrada',
                'Potencia',
                'Kilometros',
            ]);

        });
    }

};
