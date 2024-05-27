@extends('layouts.layout')

@section('contenido')

    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-pistas">

            <h2>Gestión de pistas</h2>

            <a href="{{route('pistas.create')}}"><button class="nueva-pista">Nueva Pista</button></a>

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
                        <td class="td-actions">
                            <div class="left-action">
                                <a href="{{ route('pistas.show', $pista->id_pista) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                            </div>
                            <div class="right-action">
                                <form action="{{route("pistas.destroy", $pista->id_pista)}}" method="POST">
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

        <div class="pistas">
            <div class="pista">
                <h2>PISTA 1</h2>
                @foreach($pistasPista1->chunk(4) as $chunk)
                <div class="horasP">
                    @foreach($chunk as $pista)
                        <form action="{{route("pistas.reservar", $pista->id_pista)}}" method="POST">
                            @csrf
                            <button class="reservarP" type="submit">
                                <div class="info-pista">
                                    <p>{{ $pista->fecha }}</p>
                                    <p>{{ $pista->hora_inicio }}</p>
                                </div>
                            </button>
                        </form>
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="pista">
                <h2>PISTA 2</h2>
                @foreach($pistasPista2->chunk(4) as $chunk)
                <div class="horasP">
                    @foreach($chunk as $pista)
                        <form action="{{route("pistas.reservar", $pista->id_pista)}}" method="POST">
                            @csrf
                            <button class="reservarP" type="submit">
                                <div class="info-pista">
                                    <p>{{ $pista->fecha }}</p>
                                    <p>{{ $pista->hora_inicio }}</p>
                                </div>
                            </button>
                        </form>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Mostrar la alerta si hay un mensaje de sesión
                @if(session('info'))
                Swal.fire({
                    icon: "success",
                    title: "¡Sesión reservada correctamente!",
                    showConfirmButton: false,
                    timer: 2000
                });

                @elseif(session('errorLimite'))
                Swal.fire({
                    icon: "warning",
                    title: "¡Has alcanzado el limite de reservas para ese día!",
                    showConfirmButton: false,
                    timer: 3000
                });
                @endif
            });

        </script>

    @endif
@endsection

