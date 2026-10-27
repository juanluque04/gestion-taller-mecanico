<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tarea;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';
    protected $primaryKey = 'id_Foto';


    protected $fillable = [
        'Url',
        'Tipo',
        'Fecha',
        'id_Tarea',
    ];

    protected $casts = [
        'Fecha' => 'date',
    ];
    

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_Tarea', 'id_Tarea');
    }
}
