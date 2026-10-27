<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'Nombre'        => 'Juan Luque',
            'NombreUsuario' => 'juanluque',
            'Correo'        => 'juanluque07@gmail.com',
            'Contrasena'    => Hash::make('123456'),
            'Rol'           => 'jefe',
        ]);

        $this->call([
            TrabajadoresSeeder::class,
            ClientesSeeder::class,
            ReparacionesSeeder::class,
            TareasSeeder::class,
        ]);

    }
}
