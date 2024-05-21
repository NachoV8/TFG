@extends("layouts.layout")

@section("contenido")

    <h2>INSERTAR USUARIO</h2>

    <div class="formulario-insertar-usuario">
        <!--Formulario que al aceptar creas un alumno (a través de la ruta alumnos.store)-->
        <form action="{{route('users.store')}}" method="POST">
            @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre"/>
            <!--<input class="mt-2" :messages="$errors->get('nombre')"/>--><br>

            <label for="email">Correo</label>
            <input type="email" name="email"/>

            <label for="password">Contraseña</label>
            <input type="password" name="password"/>
            <!--<x-input-error class="mt-2" :messages="$errors->get('dir')"/>--><br>

            <label for="rol">Rol</label>
            <select name="rol" id="rol" required>
                <option value="1">Usuario</option>
                <option value="2">Profesor</option>
            </select><br>

            <button>Inscribir</button>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </form>
    </div>

@endsection
