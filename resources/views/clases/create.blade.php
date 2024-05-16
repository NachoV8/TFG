@extends("layouts.layout")

@section("contenido")
    <!--Formulario para crear una nueva clase-->
    <form class="form_torneo" action="{{ route('clases.store') }}" method="POST">
        @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->

        <!-- Campo para el ID del profesor -->
        <label for="id_profesor">ID del Profesor:</label>
        <select name="id_profesor" id="id_profesor">
            @foreach($profesores as $profesor)
                <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
            @endforeach
        </select>

        <!-- Campo para el precio -->
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio">

        <!-- Campo para la descripción -->
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="5"></textarea>

        <!-- Campo para seleccionar la pista -->
        <label for="pista">Pista:</label>
        <select name="pista" id="pista">
            @foreach($pistasDisponibles as $pista)
                <option value="{{ $pista->id_pista }}">{{ $pista->pista }} - {{ $pista->fecha }} - {{ $pista->hora_inicio }}</option>
            @endforeach
        </select>

        <!-- Botón de Enviar -->
        <button type="submit">Enviar</button>
    </form>
@endsection
