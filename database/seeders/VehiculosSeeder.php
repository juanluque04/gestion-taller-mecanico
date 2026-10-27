<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculosSeeder extends Seeder
{
    public function run(): void
    {
        Vehiculo::insert([
            [
                'Marca'      => 'Toyota',
                'Modelo'     => 'Corolla',
                'Ano'        => 2018,
                'Matricula'  => '1234ABC',
                'id_Cliente' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Marca'      => 'Ford',
                'Modelo'     => 'Focus',
                'Ano'        => 2016,
                'Matricula'  => '5678DEF',
                'id_Cliente' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Marca'      => 'Volkswagen',
                'Modelo'     => 'Golf',
                'Ano'        => 2020,
                'Matricula'  => '9876GHI',
                'id_Cliente' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Marca'      => 'Renault',
                'Modelo'     => 'Clio',
                'Ano'        => 2017,
                'Matricula'  => '1122JKL',
                'id_Cliente' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
