@extends("layouts.layout")

@section("contenido")
    <div>
        <h2>Modificar Pista</h2>
        <div class="formulario-editar-pistas">
            <!--Los campos van con la información del alumno que recibe-->
            <!--Cuando se acepte el form se pasa a la ruta de update-->
            <form action="{{ route('pistas.update', $pista->id_pista) }}" method="POST">
                @csrf
                <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
                @method("PATCH")


                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                    <option value="0" {{ $pista->estado == 0 ? 'selected' : '' }}>Libre</option>
                    <option value="1" {{ $pista->estado == 1 ? 'selected' : '' }}>Ocupado</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('estado')"/><br>

                <label for="pista">Pista</label>
                <input type="number" min="1" max="2" name="pista" value="{{ $pista->pista }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('pista')"/><br>

                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" value="{{ $pista->fecha }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('fecha')"/><br>

                <label for="hora_inicio">Hora Inicio </label>
                <input type="time" name="hora_inicio" value="{{ $pista->hora_inicio }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('hora_inicio')"/><br>


                <label for="hora_fin">Hora Fin</label>
                <input type="time" name="hora_fin" value="{{ $pista->hora_fin }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('hora_fin')"/><br>

                <label for="id_usuario">Usuario</label>
                <input type="email" name="id_usuario" value="{{ $pista->usuario->email ?? '' }}" placeholder="Correo del usuario"/>
                <x-input-error class="mt-2" :messages="$errors->get('id_usuario')"/><br>

                @error('id_usuario')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection
