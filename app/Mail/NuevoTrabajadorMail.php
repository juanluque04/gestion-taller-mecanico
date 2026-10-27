<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoTrabajadorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $usuario;
    public $password;

    public function __construct($nombre, $usuario, $password)
    {
        $this->nombre = $nombre;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bienvenido al Taller - Credenciales de acceso')->view('mails.nuevoTrabajador');
    }

}
