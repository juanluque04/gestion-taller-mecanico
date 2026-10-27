<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tarea;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';


    protected $fillable = [
        'Nombre',
        'NombreUsuario',
        'Correo',
        'Contrasena',
        'Rol',
    ];

    protected $hidden = [
        'Contrasena',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'Contrasena' => 'hashed',
        ];
    }


    // Para que Laravel use "Contrasena" como columna de login
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'user_id', 'user_id');
    }
}
