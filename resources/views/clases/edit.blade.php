@extends("layouts.layout")

@section("contenido")

    <div>
        <h3>Modificar Clase</h3>
        <div class="formulario-editar-clase">
            <form action="{{ route('clases.update', $clase->id_clase) }}" method="POST">
                @csrf
                @method("PATCH")

                <label for="id_profesor">Profesor</label>
                <select name="id_profesor" id="id_profesor">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ $clase->id_profesor == $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_profesor')"/><br>

                <label for="id_pista">Pista:</label>
                <select name="id_pista" id="id_pista">
                    @foreach($pistasDisponibles as $pistaDisponible)
                        <option value="{{ $pistaDisponible->id_pista }}" {{ $clase->id_pista == $pistaDisponible->id_pista ? 'selected' : '' }}>
                            {{ $pistaDisponible->pista }} - {{ $pistaDisponible->fecha }} - {{ $pistaDisponible->hora_inicio }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_pista')"/><br>

                <label for="id_alumno">Alumno</label>
                <input type="email" name="id_alumno" value="{{ $clase->usuario->email ?? '' }}" placeholder="Si no tiene ningun alumno se deja vacio"/>
                <x-input-error class="mt-2" :messages="$errors->get('id_alumno')"/><br>

                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" value="{{ $clase->descripcion }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/><br>

                <label for="precio">Precio</label>
                <input type="number" name="precio" value="{{ $clase->precio }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>

                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection
