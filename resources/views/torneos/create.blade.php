@extends("layouts.layout")

@section("contenido")

<h1>Crear Torneo</h1>

<form action="{{ route('torneos.store') }}" method="POST">
    @csrf

    <!-- Nombre del torneo -->
    <div>
        <label for="nombre">Nombre del Torneo:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>

    <!-- Descripción del torneo -->
    <div>
        <label for="descripcion">Descripción del Torneo:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
    </div>

    <!-- Premios -->
    <div>
        <label for="premios">Premios</label>
        <input type="text" id="premios" name="premios" required>
    </div>

    <!-- Precio de inscripción -->
    <div>
        <label for="precio">Precio de Inscripción:</label>
        <input type="number" id="precio" name="precio" required>
    </div>

    <!-- Cantidad Máxima de Jugadores -->
    <div>
        <label for="cant_max">Cantidad Máxima de Jugadores:</label>
        <input type="number" id="cant_max" name="cant_max" required>
    </div>

    <!-- Selección de pistas -->
    <div>
        <label for="pistas">Selecciona las pistas para el torneo:</label>
        <select name="pistas[]" id="pistas" multiple required>
            @foreach($pistasLibres as $pista)
                <option value="{{ $pista->id_pista }}">{{ $pista->pista }} - {{ $pista->fecha }} - {{ $pista->hora_inicio }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit">Crear Torneo</button>
</form>


@endsection
