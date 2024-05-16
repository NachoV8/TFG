@extends('layouts.layout')

@section('contenido')


    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-">

            <h2>Gestión de pistas</h2>

            <a href="{{route('pistas.create')}}"><button>Nueva Pista</button></a>

            <table>
                <tr>
                    <th>Estado</th>
                    <th>Pista</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
                @foreach($pistas as $pista)
                    <tr>
                        <td>{{$pista->estado == 0 ? 'Libre' : 'Ocupada'}}</td>
                        <td>{{$pista->pista}}</td>
                        <td>{{$pista->fecha}}</td>
                        <td>{{$pista->hora_inicio}}</td>
                        <td>{{$pista->hora_fin}}</td>
                        <td>{{$pista->usuario ? $pista->usuario->name : 'Sin usuario'}}</td>
                        <td>
                            <a href="{{ route('pistas.show', $pista->id_pista) }}">Editar</a>
                            <form action="{{route("pistas.destroy", $pista->id_pista)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

    @else

        <div class="pistas">
            <div class="pista">
                <h2>PISTA 1</h2>
                <div class="horasP">
                    <table class="tabla-pista">
                        <tr>
                            <th>Estado</th>
                            <th>Pista</th>
                            <th>Fecha</th>
                        </tr>
                        @foreach($pistasPista1 as $pista)
                            <tr>
                                <td>{{$pista->fecha}}</td>
                                <td>{{$pista->hora_inicio}}</td>
                                <td>{{$pista->hora_fin}}</td>
                                <td>
                                    <form action="{{route("pistas.reservar", $pista->id_pista)}}" method="POST">
                                        @csrf
                                        <button class="reservarP" type="submit">Reservar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="pista">
                <h2>PISTA 2</h2>
                <div class="horasP">
                    <table class="tabla-pista">
                        <tr>
                            <th>Estado</th>
                            <th>Pista</th>
                            <th>Fecha</th>
                        </tr>
                        @foreach($pistasPista2 as $pista)
                            <tr>
                                <td>{{$pista->fecha}}</td>
                                <td>{{$pista->hora_inicio}}</td>
                                <td>{{$pista->hora_fin}}</td>
                                <td>
                                    <form action="{{route("pistas.reservar", $pista->id_pista)}}" method="POST">
                                        @csrf
                                        <button class="reservarP" type="submit">Reservar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>


    @endif


@endsection