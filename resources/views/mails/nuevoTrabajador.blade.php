<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Taller</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            max-width: 580px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #0a3d62;
            font-size: 22px;
            margin-bottom: 10px;
        }
        p {
            color: #333;
            line-height: 1.6;
        }
        .box {
            background: #f0f4ff;
            border-left: 4px solid #1e90ff;
            padding: 12px 18px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #1e90ff;
            color: #fff !important;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 15px;
            text-decoration: none;
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>¡Bienvenido al Taller, {{ $nombre }}!</h1>

    <p>
        Tu cuenta ha sido creada correctamente y ya puedes acceder al sistema interno del taller.
        Aquí tienes tus credenciales de acceso:
    </p>

    <div class="box">
        <strong>Usuario:</strong> {{ $usuario }}<br>
        <strong>Contraseña temporal:</strong> {{ $password }}
    </div>

    <p>
        Por motivos de seguridad, te recomendamos cambiar la contraseña cuando inicies sesión por primera vez.
    </p>

    <a href="{{ url('/login') }}" class="button">Acceder al sistema</a>

    <p class="footer">
        Este es un mensaje automático. Por favor, no respondas a este correo.
        <br>
        © {{ date('Y') }} Taller Mecánico — Todos los derechos reservados.
    </p>

</div>

</body>
</html>
