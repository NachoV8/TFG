@extends("layouts.layout")

@section("contenido")

            <!--Formulario que al aceptar creas un alumno (a través de la ruta alumnos.store)-->
            <form class="form_torneo" action="{{route('sesiones.store')}}" method="POST">
                @CSRF <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->
                <label for="estado">Estado</label>
                <input type="number" min="0" max="1" name="estado"/>
                <!--Enseña los errores-->
                <!--<input class="mt-2" :messages="$errors->get('nombre')"/>--><br>
                <label for="pista">Pista</label>
                <input type="number" min="1" max="2" name="pista"/>

                <label for="fecha">Fecha</label>
                <input type="date" name="fecha"/>
                <!--<x-input-error class="mt-2" :messages="$errors->get('dir')"/>--><br>

                <label for="hora_inicio">Hora Inicio</label>
                <input type="time" name="hora_inicio"/>

                <label for="hora_fin">Hora Fin</label>
                <input type="time" name="hora_fin"/>

                <label for="id_usuario">Id_usuario</label>
                <input type="number" name="id_usuario"/>

                <button>Enviar</button>
            </form>

@endsection
