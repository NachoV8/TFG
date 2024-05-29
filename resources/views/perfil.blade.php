@extends('layouts.layout')

@section('contenido')
    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-usuarios">

            <h2>Gestión de usuarios</h2>

            <a href="{{route('users.create')}}"><button class="nuevo-usuario">Nuevo Usuario</button></a>

            <div class="lista">
                <div>
                    <h2>Profesores</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profesores as $profesor)
                            <tr>
                                <td>{{ $profesor->name }}</td>
                                <td>{{ $profesor->email }}</td>
                                <td class="td-actions">
                                    <div class="left-action">
                                        <a href="{{ route('users.edit', $profesor->id) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                                    </div>
                                    <div class="right-action">
                                        <form action="{{route("users.destroy", $profesor->id)}}" method="POST">
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
                        </tbody>
                    </table>
                </div>

                <div>
                    <h2>Usuarios</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td class="td-actions">
                                    <div class="left-action">
                                        <a href="{{ route('users.edit', $usuario->id) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                                    </div>
                                    <div class="right-action">
                                        <form action="{{route("users.destroy", $usuario->id)}}" method="POST">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else
        <div class="perfil">
            <div class="info-perfil">
                <img src="{{ asset('imagenes/perfil/Pelota.png') }}" alt="Avatar Usuario">
                <h1>Hola, {{ Auth::user()->name }} !</h1>
            </div>
            <div class="infoP-1">
                <div class="info-personal">
                    <h3>TU INFORMACIÓN</h3>
                    <p>Partidos Jugados: <div class="part-jugados">{{ Auth::user()->num_partidos }}</div></p>
                </div>
                <div class="info-partidos">
                    <h3>TUS PARTIDOS</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora inicio</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservasPistas as $pista)
                            <tr>
                                <td>{{ $pista->fecha }}</td>
                                <td>{{ $pista->hora_inicio }}</td>
                                <td>
                                    <form action="{{ route('perfil.cancelar', $pista->id_pista) }}" method="POST" class="cancelar-form">
                                        @csrf
                                        @method("PATCH")
                                        <button type="button" class="cancelar-btn">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="infoP-2">
                <div class="info-torneos">
                    <h3>TUS TORNEOS</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Torneo</th>
                            <th>Fecha</th>
                            <th>Hora inicio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservasTorneo as $inscripcion)
                            <tr>
                                <td>{{ $inscripcion->torneo->nombre }}</td>
                                <td>{{ $inscripcion->torneo->fecha }}</td>
                                <td>{{ $inscripcion->torneo->hora_inicio }}</td>
                                <td>
                                    <form action="{{ route('perfil.cancelar', $inscripcion->id_torneo) }}" method="POST" class="cancelar-form">
                                        @csrf
                                        @method("PATCH")
                                        <button type="button" class="cancelar-btn">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="info-clases">
                    <h3>TUS CLASES</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Profesor</th>
                            <th>Fecha</th>
                            <th>Hora inicio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservasClases as $clase)
                            <tr>
                                <td>{{ $clase->profesor->name }}</td>
                                <td>{{ $clase->fecha }}</td>
                                <td>{{ $clase->hora_inicio }}</td>
                                <td>
                                    <form action="{{ route('perfil.cancelar', $clase->id_clase) }}" method="POST" class="cancelar-form">
                                        @csrf
                                        @method("PATCH")
                                        <button type="button" class="cancelar-btn">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="infoP-3">
                <div class="info-productos">
                    <h3>TUS PRODUCTOS</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservasProductos as $productoReservado)
                            <tr>
                                <td>{{ $productoReservado->producto->nombre }}</td>
                                <td>{{ $productoReservado->cantidad }}</td>
                                <td>{{ $productoReservado->cantidad * $productoReservado->producto->precio }}</td>
                                <td>
                                    <form action="{{ route('reserva.producto.cancelar', $productoReservado->id_reserva) }}" method="POST" class="cancelar-form">
                                        @csrf
                                        @method("DELETE")
                                        <button type="button" class="cancelar-btn">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection


    <style>
        .btn-custom-success {
            background-color: #1b7700;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-custom-danger {
            background-color: #d33;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-custom-success:hover, .btn-custom-danger:hover {
            opacity: 0.8;
        }
    </style>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.cancelar-btn');

            buttons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const form = this.closest('form'); // Encuentra el formulario más cercano

                    Swal.fire({
                        html: "<h2 style='text-align: center; color: black'>¿Estás seguro de que quieres eliminar la reserva?</h2>",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1b7700",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Cancelar",
                        confirmButtonText: "Si, quiero eliminarla",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                html: "<h2 style='text-align: center; color: black'>¡Eliminada!</h2>",
                                text: "Tu reserva ha sido eliminada",
                                icon: "success",
                                confirmButtonColor: "#1b7700",
                            }).then(() => {
                                form.submit(); // Envía el formulario después de mostrar la alerta de confirmación
                            });
                        }
                    });
                });
            });
        });
    </script>

