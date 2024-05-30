<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <link rel="shortcut icon" href="/imagenes/Logo.png"/>

    <title>Padel Indoor Turiaso</title>
</head>
<body>
    <div class="login">
        <div class="logo">
            <img src="{{ asset('imagenes/Logo.png') }}" alt="Logo Pade Indoor">
        </div>
        <div class="form">
            <div class="formulario">
                <h2>Inicio de Sesión</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" required><br><br>
                    <x-input-error class="mt-2" :messages="$errors->get('email')"/><br>


                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required><br><br>
                    <x-input-error class="mt-2" :messages="$errors->get('password')"/><br>


                    <div class="registrarse">
                        <p>No tienes cuenta? <a href="register">Registrate</a></p>
                    </div>

                    <div class="botones">
                        <a href="../"><button class="cancelar" type="button">Cancelar</button></a>
                        <button class="enviar" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

