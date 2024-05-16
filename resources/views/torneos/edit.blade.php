@extends("layouts.layout")

@section('contenido')

    <form class="form_torneo" action="{{route('torneos.update', $torneo->id_torneo)}}" method="POST">


    @csrf

    @method("PATCH")
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" value="{{ $torneo->nombre }}"><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion">{{ $torneo->descripcion }}</textarea><br>

        <label for="premios">Premios:</label><br>
        <textarea id="premios" name="premios">{{ $torneo->premios }}</textarea><br>

        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" value="{{ $torneo->precio }}"><br>

        <label for="cant_max">Cantidad Máxima de Jugadores:</label><br>
        <input type="number" id="cant_max" name="cant_max" value="{{ $torneo->cant_max }}"><br>

        <label for="hora_inicio">Fecha de Inicio:</label><br>
        <input type="time" id="hora_inicio" name="hora_inicio" value="{{ $torneo->hora_inicio }}"><br>

        <label for="hora_fin">Fecha de Fin:</label><br>
        <input type="time" id="hora_fin" name="hora_fin" value="{{ $torneo->hora_fin }}"><br>

        <label for="pista">Pista:</label><br>
        <input type="text" id="pista" name="pista" value="{{ $torneo->id_pista }}"><br>


        <button type="submit">Actualizar</button>

    </form>
@endsection
