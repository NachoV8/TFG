@extends('layouts.layout')

@section('contenido')

    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-clases">

            <h2>Gestión de clases</h2>

            <a href="{{route('clases.create')}}"><button class="nueva-clase">Nueva Clase</button></a>

            <table>
                <tr>
                    <th>Profesor</th>
                    <th>Pista</th>
                    <th class="th-descripcion">Descripcion</th>
                    <th>Precio</th>
                    <th>Hora de Inicio</th>
                    <th>fecha_clase</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($clases as $clase)
                    <tr>
                        <td>{{ $clase->profesor->name }}</td>
                        <td>{{ $clase->pista->pista }}</td>
                        <td class="td-descripcion">{{ $clase->descripcion }}</td>
                        <td>{{ $clase->precio }} €</td>
                        <td>{{ $clase->hora_inicio }}</td>
                        <td>{{ $clase->fecha }}</td>
                        <td>{{$clase->alumno ? $clase->alumno->name : 'Sin alumno'}}</td>
                        <td class="td-actions">
                            <div class="left-action">
                                <a href="{{ route('clases.show', $clase->id_clase) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                            </div>
                            <div class="right-action">
                                <form action="{{route("clases.destroy", $clase->id_clase)}}" method="POST">
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
        </div>

    @elseif (Auth::check() && Auth::user()->rol == 2)


        <div class="admin-clases">

            <h2>Gestión de clases</h2>

            <a href="{{route('clases.create')}}"><button class="nueva-clase">Nueva Clase</button></a>

            <table>
                <tr>
                    <th>Profesor</th>
                    <th>Pista</th>
                    <th class="th-descripcion">Descripcion</th>
                    <th>Precio</th>
                    <th>Hora de Inicio</th>
                    <th>fecha_clase</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($clasesProfesor as $clase)
                    <tr>
                        <td>{{ $clase->profesor->name }}</td>
                        <td>{{ $clase->pista->pista }}</td>
                        <td class="td-descripcion">{{ $clase->descripcion }}</td>
                        <td>{{ $clase->precio }} €</td>
                        <td>{{ $clase->hora_inicio }}</td>
                        <td>{{ $clase->fecha }}</td>
                        <td>{{$clase->alumno ? $clase->alumno->name : 'Sin alumno'}}</td>
                        <td class="td-actions">
                            <div class="left-action">
                                <a href="{{ route('clases.show', $clase->id_clase) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                            </div>
                            <div class="right-action">
                                <form action="{{route("clases.destroy", $clase->id_clase)}}" method="POST">
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
        </div>
    @else

    <div class="usuario-clases">
        <h1>Clases Disponibles</h1>
        <div class="clases">
            @foreach($clasesDisponibles->chunk(3) as $chunk)
                <div class="clasesF">
                    @foreach($chunk as $clase)
                        <div class="clase">
                            <h2>{{ $clase->profesor->name }}</h2>
                            <p>{{ $clase->descripcion }}</p>
                            <div class="info-clase">
                                <p>{{ $clase->precio }}€</p>
                                <p>{{ $clase->fecha }}</p>
                                <p>{{ $clase->hora_inicio }}</p>
                            </div>
                            <form action="{{ route('reservar.clase', $clase->id_clase) }}" method="POST">
                                @csrf
                                <button type="submit" class="button-clases">Reservar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mostrar la alerta si hay un mensaje de sesión
            @if(session('info'))
            Swal.fire({
                icon: "success",
                title: "¡Clase reservada correctamente!",
                showConfirmButton: false,
                timer: 2000
            });
            @endif
        });

    </script>

@endsection
