@extends("layouts.layout")

@section("contenido")

    <div class="crear-usuario">
        <h2>INSERTAR USUARIO</h2>

        <div class="formulario-insertar-usuario">
            <!--Formulario que al aceptar creas un alumno (a través de la ruta alumnos.store)-->
            <form action="{{route('users.store')}}" method="POST">
                @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required/>
                <x-input-error class="mt-2" :messages="$errors->get('nombre')"/><br>


                <label for="email">Correo</label>
                <input type="email" name="email" required/>
                <x-input-error class="mt-2" :messages="$errors->get('email')"/><br>


                <label for="password">Contraseña</label>
                <input type="password" name="password" required/>
                <x-input-error class="mt-2" :messages="$errors->get('password')"/><br>

                <label for="rol">Rol</label>
                <select name="rol" id="rol" required>
                    <option value="1">Usuario</option>
                    <option value="2">Profesor</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('rol')"/><br>


                <button>Inscribir</button>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

@endsection
