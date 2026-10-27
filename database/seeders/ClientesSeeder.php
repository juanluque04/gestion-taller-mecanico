<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Vehiculo;
use Faker\Factory as Faker;

class ClientesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 5; $i++) {

            // Generar DNI válido
            $dniNumber = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $dniLetters = "TRWAGMYFPDXBNJZSQVHLCKE";
            $dni = $dniNumber . $dniLetters[$dniNumber % 23];

            // Crear cliente
            $cliente = Cliente::create([
                'Nombre'     => $faker->name(),
                'Telefono'   => $faker->numerify('6########'), // móvil español
                'DNI'        => $dni,
                'Direccion'  => $faker->streetAddress(),
            ]);

            // Crear entre 1 y 3 vehículos
            $numVehiculos = rand(1, 3);

            for ($v = 0; $v < $numVehiculos; $v++) {

                $matricula = strtoupper($faker->bothify('####??'));

                Vehiculo::create([
                    'Marca'       => $faker->randomElement(['Ford', 'Seat', 'BMW', 'Audi', 'Opel', 'Renault']),
                    'Modelo'      => $faker->randomElement(['Focus', 'Ibiza', 'A3', 'Corsa', 'Megane', 'Serie 1']),
                    'Version'     => $faker->optional()->word(),
                    'Ano'         => rand(1999, 2024),
                    'Matricula'   => $matricula,
                    'Kilometros'  => rand(5000, 250000),
                    'Bastidor'    => strtoupper($faker->bothify('#################')),
                    'NumeroMotor' => strtoupper($faker->bothify('MTR#######')),
                    'TipoMotor'   => $faker->randomElement(['Gasolina', 'Diésel', 'Híbrido', 'Eléctrico']),
                    'Cilindrada'  => $faker->randomElement(['1.2', '1.4', '1.6', '2.0']),
                    'Potencia'    => rand(70, 250) . ' CV',
                    'id_Cliente'  => $cliente->id_Cliente,
                ]);
            }

        }
    }
}
