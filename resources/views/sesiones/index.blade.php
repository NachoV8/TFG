@extends('layouts.layout')

@section('contenido')
    <div class="pistas">
        <div class="pista">
            <h2>PISTA 1</h2>
            <div class="horasP">
                <table class="tabla-sesion">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                    </tr>
                    @foreach($sesionesPista1 as $sesion)
                        <tr>
                            <td>{{$sesion->fecha}}</td>
                            <td>{{$sesion->hora_inicio}}</td>
                            <td>{{$sesion->hora_fin}}</td>
                            <td>
                                <form action="{{route("sesiones.reservar", $sesion->id_sesion)}}" method="POST">
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
                <table class="tabla-sesion">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                    </tr>
                    @foreach($sesionesPista2 as $sesion)
                        <tr>
                            <td>{{$sesion->fecha}}</td>
                            <td>{{$sesion->hora_inicio}}</td>
                            <td>{{$sesion->hora_fin}}</td>
                            <td>
                                @if(Auth::check())
                                    <form action="{{route("sesiones.reservar", $sesion->id_sesion)}}" method="POST">
                                        @csrf
                                        <button class="reservarP" type="submit">Reservar</button>
                                    </form>
                                @else
                                    <a href="login"><button class="reservarP">Reservar</button></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    @if(Auth::check() && Auth::user()->rol == 3)

    <a href="{{route('sesiones.create')}}"><button>Nueva Pista</button></a>


    <h2>Todas las pistas</h2>
    <table>
        <tr>
            <th>Estado</th>
            <th>Pista</th>
            <th>Fecha</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Id_usuario</th>
            <th>Acciones</th>
        </tr>
        @foreach($sesiones as $sesion)
            <tr>
                <td>{{$sesion->estado == 0 ? 'Libre' : 'Ocupada'}}</td>
                <td>{{$sesion->pista}}</td>
                <td>{{$sesion->fecha}}</td>
                <td>{{$sesion->hora_inicio}}</td>
                <td>{{$sesion->hora_fin}}</td>
                <td>{{$sesion->id_usuario}}</td>
                <td>
                    <a href="{{route('sesiones.show', $sesion->id_sesion)}}">Editar</a>
                    <form action="{{route("sesiones.destroy", $sesion->id_sesion)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    @endif
@endsection
