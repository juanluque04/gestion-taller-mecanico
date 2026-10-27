<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reparacion;
use App\Models\User;
use App\Models\Material;
use App\Models\Foto;


class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $primaryKey = 'id_Tarea';


    protected $fillable = [
        'Descripcion',
        'Estado',
        'FechaRealizada',
        'HorasPrevistas',
        'HorasReales',
        'Importe',
        'Observaciones',
        'Prioridad',
        'FechaProgramada',
        'id_Reparacion',
        'user_id',
    ];

    protected $casts = [
        'FechaRealizada'    => 'date',
        'FechaProgramada'   => 'date',
    ];

    
    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class, 'id_Reparacion', 'id_Reparacion');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'id_Tarea', 'id_Tarea');
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_Tarea', 'id_Tarea');
    }

}
