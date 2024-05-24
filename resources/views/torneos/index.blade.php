@extends('layouts.layout')

@section('contenido')


    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-torneos">


        <h2>Gestión de Torneos</h2>

        <a href="{{ route('torneos.create') }}"><button class="nuevo-torneo">Nuevo Torneo</button></a>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Fecha</th>
                <th>Hora inicio</th>
                <th>Cantidad Jugadores</th>
                <th>Acciones</th>
            </tr>
            @foreach ($torneos as $torneo)
                <tr>
                    <td>{{ $torneo->nombre }}</td>
                    <td>{{ $torneo->descripcion }}</td>
                    <td>{{ $torneo->precio }}</td>
                    <td>{{ $torneo->fecha }}</td>
                    <td>{{ $torneo->hora_inicio }}</td>
                    <td>{{ $torneo->cant_max }}</td>
                    <td class="td-actions">
                        <div class="left-action">
                            <a href="{{ route('torneos.show', $torneo->id_torneo) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                        </div>
                        <div class="right-action">
                            <form action="{{route("torneos.destroy", $torneo->id_torneo)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="delete-btn">
                                    <img src="{{ asset('imagenes/index/borrar.png') }}" alt="Eliminar">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>

    @else

    <div class="torneos">
        <div class="torneosA">
            @foreach($torneos as $torneo)
                <div class="torneo">
                    <h2>{{ $torneo->nombre }}</h2>
                    <div class="texto">
                        <p>{{ $torneo->descripcion }}</p>
                        <p>Premios: <br>
                            {{ $torneo->premios }} <br>
                        </p>
                        <p>{{ $torneo->precio }} € p.p.</p>
                        <p>{{ $torneo->fecha }} -> {{ $torneo->hora_inicio }}</p>
                        <p>Jugadores inscritos: {{ $torneo->inscritos }} / {{ $torneo->cant_max }}</p>
                    </div>
                    <form action="{{ route('torneos.reservar', $torneo->id_torneo) }}" method="POST">
                        @csrf
                        <button type="submit" class="button-torneos">Inscribirme</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    @endif

@endsection
