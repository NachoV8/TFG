<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">

    <title>Document</title>
</head>
<body>
    <div class="registro">
        <div class="logo">
            <img src="{{ asset('imagenes/Logo.png') }}" alt="Logo Pade Indoor">
        </div>
        <div class="form">
            <div class="formulario">
                <h2>Registro</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <label for="name">Nombre de Usuario:</label><br>
                    <input type="text" id="name" name="name" required><br><br>

                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required><br><br>

                    <label for="confirm_password">Confirmar Contraseña:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                    <div class="botones">
                        <a href="../"><button class="cancelar" type="button">Cancelar</button></a>
                        <button class="enviar" type="submit"> Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
