<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;


class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    //asigacion de nuevo nombre a la pk de "Clientes"
    protected $primaryKey = 'id_Cliente';

    //campos rellenables en formularios
    protected $fillable = [
        'Nombre',
        'Telefono',
        'DNI',
        'Direccion'
    ];


    
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_Cliente', 'id_Cliente');
    }
}
