@extends('layouts.layout')

@section('contenido')
    <div class="pistas">
        <div class="pista">
            <h2>PISTA 1</h2>
            <div class="horasP">
                <p>Prueba</p>
            </div>
        </div>
        <div class="pista">
            <h2>PISTA 2</h2>
            <div class="horasP">
                <p>Prueba</p>
            </div>
        </div>
    </div>
    <a class="crearT" href="{{ route('pistas.create') }}">Crear Nueva Pista</a>

    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Hora de Inicio</th>
            <th>Hora de Fin</th>
            <th>ID de Usuario</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pistas as $pista)
            <tr>
                <td>{{ $pista->id_pista }}</td>
                <td>{{ $pista->estado }}</td>
                <td>{{ $pista->fecha }}</td>
                <td>{{ $pista->hora_inicio }}</td>
                <td>{{ $pista->hora_fin }}</td>
                <td>{{ $pista->id_usuario }}</td>
                <td>
                    <a href="{{ route('pistas.show', $pista->id_pista) }}">Ver Detalles</a>
                    <a href="{{ route('pistas.update', $pista->id_pista) }}">Editar</a>
                    <form action="{{ route('pistas.destroy', $pista->id_pista) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
