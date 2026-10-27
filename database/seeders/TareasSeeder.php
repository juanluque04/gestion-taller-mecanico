<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Reparacion;
use App\Models\User;

class TareasSeeder extends Seeder
{
    public function run()
    {
        $reparaciones = Reparacion::all();
        $trabajadores = User::where('Rol', 'trabajador')->get();

        foreach ($reparaciones as $reparacion) {

           
            $cantidad = rand(1, 6);

            for ($i = 0; $i < $cantidad; $i++) {

                Tarea::create([
                    'id_Reparacion' => $reparacion->id_Reparacion,
                    'user_id' => $trabajadores->random()->user_id,
                    'Descripcion' => fake()->sentence(),
                    'Prioridad' => fake()->randomElement(['baja', 'media', 'alta']),
                    'Estado' => fake()->randomElement(['pendiente','en curso','terminada','revisada']),
                    'HorasPrevistas' => rand(1, 8),
                    'HorasReales' => rand(0, 8),
                    'FechaProgramada' => fake()->dateTimeBetween('-1 months', '+1 months'),
                    'Importe' => rand(20, 350)
                ]);
            }
        }
    }
}
