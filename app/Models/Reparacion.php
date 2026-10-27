<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vehiculo;
use App\Models\Tarea;

class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparaciones';
    protected $primaryKey = 'id_Reparacion';


    protected $fillable = [
        'FechaEntrada',
        'FechaSalida',
        'Estado',
        'Observaciones',
        'id_Vehiculo',
    ];

    // $casts sirve para poder dar formato y poder trabajar mejor con las fechas
    protected $casts = [
        'FechaEntrada' => 'date',
        'FechaSalida'  => 'date',
    ];


    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_Vehiculo', 'id_Vehiculo');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_Reparacion', 'id_Reparacion');
    }



}
