@extends("layouts.layout")

@section("contenido")
    <div class="flex items-center justify-center h-full p-5 rounded-2xl">
        <div class="w-full max-w-md h-full">
            <!--Los campos van con la información del alumno que recibe-->
            <!--Cuando se acepte el form se pasa a la ruta de update-->
            <form action="{{route('sesiones.update', $sesion->id_sesion)}}" method="POST">
                @csrf
                <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
                @method("PATCH")
                <label for="estado">Estado</label>
                <input type="number" min="0" max="1" name="estado" value="{{$sesion->estado}}"/>
                <!--Enseña los errores-->
                <x-input-error class="mt-2" :messages="$errors->get('estado')"/><br>

                <label for="pista">Pista</label>
                <input type="number" min="1" max="2" name="pista" value="{{$sesion->pista}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('pista')"/><br>


                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" value="{{$sesion->fecha}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('fecha')"/><br>

                <label for="hora_inicio">Hora Inicio</label>
                <input type="time" name="hora_inicio" value="{{$sesion->hora_inicio}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('hora_inicio')"/><br>


                <label for="hora_fin">Hora Fin</label>
                <input type="time" name="hora_fin" value="{{$sesion->hora_fin}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('hora_fin')"/><br>


                <label for="id_usuario">Id_usuario</label>
                <input type="number" name="id_usuario" value="{{$sesion->id_usuario = 1}}" required />
                <x-input-error class="mt-2" :messages="$errors->get('id_usuario')"/><br>


                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection
