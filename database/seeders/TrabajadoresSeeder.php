<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrabajadoresSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {

            $nombre = fake()->name();

            User::create([
                'Nombre' => $nombre,
                'NombreUsuario' => 'trabajador' . $i,
                'Correo' => 'trabajador' . $i . '@example.com',
                'Contrasena' => Hash::make('password123'),
                'Rol' => 'trabajador',
            ]);
        }
    }
}
