@extends('layouts.layout')

@section('contenido')

    <div class="perfil">
        <div class="info-perfil">
            <img src="{{ asset('imagenes/perfil/Pelota.png') }}" alt="Avatar Usuario">
            <h2>Hola, {{ Auth::user()->name }}!</h2>
        </div>
        <div class="infoP-1">
            <div class="info-personal">
                <h3>TU INFORMACIÓN</h3>
                <p>Partidos Jugados: {{ Auth::user()->num_partidos }}</p>
            </div>
            <div class="info-partidos">
                <h3>TUS PARTIDOS</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora inicio</th>
                        <!-- Otros encabezados de la tabla según tus campos de pista -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($reservasPistas as $pista)
                        <tr>
                            <td>{{ $pista->fecha }}</td>
                            <td>{{ $pista->hora_inicio }}</td>
                            <td>
                                <form action="{{ route('perfil.cancelar', $pista->id_pista) }}" method="POST">
                                    @csrf
                                    @method("PATCH")
                                    <button type="submit">Cancelar</button>
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

            </div>
            <div class="info-clases">
                <h3>TUS CLASES</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Fecha</th>
                        <th>Hora inicio</th>
                        <!-- Otros encabezados de la tabla según tus campos de pista -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($reservasClases as $clase)
                        <tr>
                            <td>{{ $clase->id_profesor }}</td>
                            <td>{{ $clase->fecha }}</td>
                            <td>{{ $clase->hora_inicio }}</td>
                            <td>
                                <form action="{{ route('perfil.cancelar', $clase->id_clase) }}" method="POST">
                                    @csrf
                                    @method("PATCH")

                                    <button type="submit">Cancelar</button>
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
                <h3>Tus Productos</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Hora inicio</th>
                        <!-- Otros encabezados de la tabla según tus campos de pista -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($reservasClases as $clase)
                        <tr>
                            <td>{{ $clase->id_profesor }}</td>
                            <td>{{ $clase->fecha }}</td>
                            <td>{{ $clase->hora_inicio }}</td>
                            <td>
                                <form action="{{ route('perfil.cancelar', $clase->id_clase) }}" method="POST">
                                    @csrf
                                    @method("PATCH")

                                    <button type="submit">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
