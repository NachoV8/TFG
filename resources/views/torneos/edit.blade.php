@extends("layouts.layout")

@section('contenido')

    <div class="editar-torneo">

        <h2>Modificar Torneo</h2>
        <form class="form_torneo" action="{{route('torneos.update', $torneo->id_torneo)}}" method="POST">

            @csrf

            @method("PATCH")

            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ $torneo->nombre }}"><br>
            <x-input-error class="mt-2" :messages="$errors->get('nombre')"/><br>


            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion">{{ $torneo->descripcion }}</textarea><br>
            <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/><br>


            <label for="premios">Premios:</label><br>
            <textarea id="premios" name="premios">{{ $torneo->premios }}</textarea><br>
            <x-input-error class="mt-2" :messages="$errors->get('premios')"/><br>


            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" value="{{ $torneo->precio }}"><br>
            <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>


            <label for="cant_max">Cantidad Máxima de Jugadores:</label><br>
            <input type="number" id="cant_max" name="cant_max" value="{{ $torneo->cant_max }}"><br>
            <x-input-error class="mt-2" :messages="$errors->get('cant_max')"/><br>


            <label for="pistas">Pistas:</label><br>
            <select id="pistas" name="pistas[]" multiple>
                @foreach( $pistasDisponibles as $pistaDisponible)
                    <option value="{{ $pistaDisponible->id_pista }}" {{ $torneo->id_pista == $pistaDisponible->id_pista ? 'selected' : '' }}>
                        {{ $pistaDisponible->pista }} - {{ $pistaDisponible->fecha }} - {{ $pistaDisponible->hora_inicio }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('pistas')"/><br>


            <button type="submit">Actualizar</button>
        </form>
    </div>

@endsection
