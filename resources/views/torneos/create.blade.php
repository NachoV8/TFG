@extends("layouts.layout")

@section("contenido")

    <div class="crear-torneo">
        <h2>Crear Torneo</h2>

        <form action="{{ route('torneos.store') }}" method="POST">
            @csrf

            <!-- Nombre del torneo -->
                <label for="nombre">Nombre del Torneo:</label>
                <input type="text" id="nombre" name="nombre" required>
                <x-input-error class="mt-2" :messages="$errors->get('nombre')"/><br>

            <!-- Descripción del torneo -->
                <label for="descripcion">Descripción del Torneo:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/><br>

            <!-- Premios -->
                <label for="premios">Premios</label>
                <input type="text" id="premios" name="premios" required>
                <x-input-error class="mt-2" :messages="$errors->get('premios')"/><br>

            <!-- Precio de inscripción -->
                <label for="precio">Precio de Inscripción:</label>
                <input type="number" id="precio" name="precio" required>
                <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>

            <!-- Cantidad Máxima de Jugadores -->
                <label for="cant_max">Cantidad Máxima de Jugadores:</label>
                <input type="number" id="cant_max" name="cant_max" required>
                <x-input-error class="mt-2" :messages="$errors->get('cant_max')"/><br>

            <!-- Selección de pistas -->
                <label for="pistas">Selecciona las pistas para el torneo:</label>
                <select name="pistas[]" id="pistas" multiple required>
                    @foreach($pistasLibres as $pista)
                        <option value="{{ $pista->id_pista }}">{{ $pista->pista }} - {{ $pista->fecha }} - {{ $pista->hora_inicio }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('pistas')"/><br>


            <button type="submit">Crear Torneo</button>
        </form>
    </div>


@endsection
