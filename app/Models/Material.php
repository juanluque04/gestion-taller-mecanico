<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tarea;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales';
    protected $primaryKey = 'id_Material';


    protected $fillable = [
        'Descripcion',
        'Cantidad',
        'Estado',
        'id_Tarea',
    ];
    

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_Tarea', 'id_Tarea');
    }
}
