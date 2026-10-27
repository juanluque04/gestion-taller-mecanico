<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reparacion;
use App\Models\Vehiculo;

class ReparacionesSeeder extends Seeder
{
    public function run()
    {
        $vehiculos = Vehiculo::all();

        foreach ($vehiculos as $vehiculo) {

            $cantidad = rand(1, 5);

            for ($i = 0; $i < $cantidad; $i++) {

                $fechaEntrada = fake()->dateTimeBetween('-1 years', 'now');
                $fechaSalida = rand(0, 1) ? fake()->dateTimeBetween($fechaEntrada, 'now') : null;

                Reparacion::create([
                    'id_Vehiculo' => $vehiculo->id_Vehiculo,
                    'FechaEntrada' => $fechaEntrada,
                    'FechaSalida' => $fechaSalida,
                    'Estado' => $fechaSalida ? 'terminada' : fake()->randomElement(['pendiente', 'en curso']),
                    'Observaciones' => fake()->sentence()
                ]);
            }
        }
    }
}
