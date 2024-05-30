<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">

    <link rel="shortcut icon" href="/imagenes/Logo.png" />

    <title>Padel Indoor Turiaso</title></head>
<body>

    <div class="formulario">
        <div class="logo">
            <img src="{{ asset('imagenes/Logo.png') }}" alt="Logo Pade Indoor">
        </div>


        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form">

                <h2>Registro</h2>

                <!-- Nombre de Usuario -->
                <div class="datos">
                    <label for="name">Nombre de Usuario:</label><br>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                    <span>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="datos">
                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="datos">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                    @error('password')
                    @if ($message == 'The password field must be at least 8 characters.')
                        <span>{{ $message = 'La contraseña debe tener al menos 8 caráctreres'}}</span>
                    @elseif( $message == 'The password field confirmation does not match')
                        <span>{{ $message = 'Las contraseñas no coinciden'}}</span>
                    @else
                        <span>{{ $message }}</span>

                    @endif
                    @enderror

                </div>

                <!-- Confirmar Contraseña -->
                <div class="datos">
                    <label for="password_confirmation">Confirmar Contraseña:</label><br>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                    <span>{{ $message = "Las contraseñas no coinciden" }}</span>
                    @enderror
                </div>

                <div class="loguearte">
                    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí.</a></p>
                </div>

                <div class="boton">
                    <a href="../"><button class="cancelar" type="button">Cancelar</button></a>
                    <button type="submit">Registrarse</button>
                </div>
            </div>

        </form>
    </div>

</body>
</html>
