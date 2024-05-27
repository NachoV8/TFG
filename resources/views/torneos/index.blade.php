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
                    <h1>Torneos Disponibles</h1>
                    @foreach($torneosDisponibles->chunk(2) as $chunk)
                        <div class="torneos-row">
                            @foreach($chunk as $torneo)
                                <div class="torneo">
                                    <h2>{{ $torneo->nombre }}</h2>
                                    <div class="texto">
                                        <div class="left">
                                            <p>{{ $torneo->descripcion }}</p>
                                            <p>{{ $torneo->precio }} € p.p.</p>
                                            <p>{{ $torneo->fecha }}</p>
                                            <p>Hora de inicio: {{ $torneo->hora_inicio }}</p>
                                        </div>
                                        <div class="right">
                                            <p class="first">{{ $torneo->premios }}</p>
                                        </div>
                                    </div>
                                    <div class="inscritos">
                                        <p>Inscritos: {{ $torneo->inscritos }} / {{ $torneo->cant_max }}</p>
                                    </div>
                                    <form action="{{ route('torneos.reservar', $torneo->id_torneo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="button-torneos">Inscribirme</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>


            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Mostrar la alerta si hay un mensaje de sesión
                    @if(session('error'))
                    Swal.fire({
                        icon: "warning",
                        title: "¡Ya estás inscrito en el torneo!",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    @elseif(session('info'))
                    Swal.fire({
                        icon: "success",
                        title: "¡Inscripción realizada!",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    @endif
                });

            </script>



@endsection
