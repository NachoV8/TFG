@extends('layouts.layout')

@section('contenido')

    <h1>Detalles de las pistas {{ $pista->id_pista }}</h1>

    <form class="form_torneo" action="{{ route('pistas.update') }}" method="POST">
        @csrf



        <label for="pista">Pista:</label><br>
        <input type="text" id="pista" name="pista" value="{{ old('pista') }}"><br>

        <label for="estado">Descripción:</label><br>
        <textarea id="estado" name="estado">{{ old('estado') }}</textarea><br>

        <label for="premios">Premios:</label><br>
        <textarea id="premios" name="premios">{{ old('premios') }}</textarea><br>

        <label for="precio">Precio:</label><br>
        <input type="text" id="precio" name="precio" value="{{ old('precio') }}"><br>

        <label for="cant_max">Cantidad Máxima de Jugadores:</label><br>
        <input type="number" id="cant_max" name="cant_max" value="{{ old('cant_max') }}"><br>

        <label for="hora_inicio">Fecha de Inicio:</label><br>
        <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}"><br>

        <label for="hora_fin">Fecha de Fin:</label><br>
        <input type="time" id="hora_fin" name="hora_fin" value="{{ old('hora_fin') }}"><br>

        <label for="pista">Pista:</label><br>
        <!--<select name="pista" id="pista">
        </select>-->
        <textarea id="pista" name="pista">{{ old('pista') }}</textarea><br>

        <button type="submit">Crear</button>

        {{ old('descripcion') }}

    </form>



    <!--<ul>

        <li>Nombre: {{ $torneo->nombre }}</li>

        <li>Descripción: {{ $torneo->descripcion }}</li>

        <li>Precio: {{ $torneo->precio }}</li>

        <li>Cantidad Maxima: {{ $torneo->cant_max }}</li>

        <li>Hora de Inicio: {{ $torneo->hora_inicio }}</li>

        <li>Hora de Fin: {{ $torneo->hora_fin }}</li>

        <li>ID Pista: {{ $torneo->id_pista }}</li>

    </ul>-->

@endsection