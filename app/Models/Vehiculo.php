<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cliente;
use App\Models\Reparacion;


class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';
    protected $primaryKey = 'id_Vehiculo';


    protected $fillable = [
        'Marca',
        'Modelo',
        'Version',
        'Bastidor',
        'NumeroMotor',
        'TipoMotor',
        'Cilindrada',
        'Potencia',
        'Kilometros',
        'Ano',
        'Matricula',
        'id_Cliente',
    ];


    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_Cliente', 'id_Cliente');
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class, 'id_Vehiculo', 'id_Vehiculo');
    }

}
