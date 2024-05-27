@extends("layouts.layout")

@section("contenido")

    <h2>CREAR PISTA</h2>

    <div class="formulario-crear-pista">
        <!--Formulario que al aceptar creas un alumno (a través de la ruta alumnos.store)-->
        <form action="{{route('pistas.store')}}" method="POST">
            @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->
            <label for="estado">Estado</label>
            <input type="number" min="0" max="1" name="estado"/>
            <x-input-error class="mt-2" :messages="$errors->get('estado')"/><br>


            <label for="pista">Pista</label>
            <input type="number" min="1" max="2" name="pista"/>
            <x-input-error class="mt-2" :messages="$errors->get('pista')"/><br>


            <label for="fecha">Fecha</label>
            <input type="date" name="fecha"/>
            <x-input-error class="mt-2" :messages="$errors->get('fecha')"/><br>


            <label for="hora_inicio">Hora Inicio</label>
            <input type="time" name="hora_inicio"/>
            <x-input-error class="mt-2" :messages="$errors->get('hora_inicio')"/><br>


            <label for="hora_fin">Hora Fin</label>
            <input type="time" name="hora_fin"/>
            <x-input-error class="mt-2" :messages="$errors->get('hora_fin')"/><br>


            <label for="usuario">Usuario</label>
            <input type="email" name="usuario" placeholder="Correo del usuario o si esta vacio no se asigna a nadie"/>
            <x-input-error class="mt-2" :messages="$errors->get('usuario')"/><br>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <button>Enviar</button>

        </form>
    </div>

@endsection
