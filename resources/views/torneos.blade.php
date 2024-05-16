@extends('layouts.layout')

@section('contenido')
    <div class="torneos">
        <div class="torneosA">
            <div class="torneo">
                <h2>Torneo XAB</h2>
                <div class="texto">
                    <p>Torneo modelo tradicional en el que habrá desde partido desde octavos!</p>
                    <p>Juega 2 partidos asegurados!</p>
                    <p>Premios: <br>
                        1º Pala BullPadel <br>
                        2º Pack 3 botes pelotas HEAD <br>
                        3º 2 Grips</p>
                    <p>12 € p.p.</p>
                </div>
                <div class="boton">
                    <a href="/torneos"><button>Apuntate</button></a>
                </div>
            </div>
            <div class="torneo">
                <h2>Torneo Americano</h2>
                <div class="texto">
                    <p>Torneo modelo americano en el que habrá desde octavos!</p>
                    <p>Juega 4 partidos asegurados!</p>
                    <p>Premios: <br>
                        1º Pala BullPadel <br>
                        2º Pack 3 botes pelotas HEAD <br>
                        3º 2 Grips</p>
                    <p>12 € p.p.</p>
                </div>
                <div class="boton">
                    <a href="/torneos"><button>Apuntate</button></a>
                </div>
            </div>
        </div>
        <div class="torneosB">
            <div class="torneo">
                <h2>Torneo XAB</h2>
                <div class="texto">
                    <p>Torneo modelo tradicional en el que habrá desde partido desde octavos!</p>
                    <p>Juega 2 partidos asegurados!</p>
                    <p>Premios: <br>
                        1º Pala BullPadel <br>
                        2º Pack 3 botes pelotas HEAD <br>
                        3º 2 Grips</p>
                    <p>12 € p.p.</p>
                </div>
                <div class="boton">
                    <a href="/torneos"><button>Apuntate</button></a>
                </div>
            </div>
            <div class="torneo">
                <h2>Torneo Americano</h2>
                <div class="texto">
                    <p>Torneo modelo americano en el que habrá desde octavos!</p>
                    <p>Juega 4 partidos asegurados!</p>
                    <p>Premios: <br>
                        1º Pala BullPadel <br>
                        2º Pack 3 botes pelotas HEAD <br>
                        3º 2 Grips</p>
                    <p>12 € p.p.</p>
                </div>
                <div class="boton">
                    <a href="/torneos"><button>Apuntate</button></a>
                </div>
            </div>
        </div>
    </div>


    <a class="crearT" href="{{ route('torneos.create') }}">Crear Nuevo Torneo</a>

    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Premios</th>
            <th>Precio</th>
            <th>Cantidad Max</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($torneos as $torneo)
            <tr>
                <td>{{ $torneo->id_torneo }}</td>
                <td>{{ $torneo->nombre }}</td>
                <td>{{ $torneo->descripcion }}</td>
                <td>{{ $torneo->premios }}</td>
                <td>{{ $torneo->precio }}</td>
                <td>{{ $torneo->cant_max }}</td>
                <td>{{ $torneo->hora_inicio }}</td>
                <td>{{ $torneo->hora_fin }}</td>
                <td>
                    <a href="{{ route('torneos.show', $torneo->id_torneo) }}">Ver Detalles</a>
                    <a href="{{ route('torneos.update', $torneo->id_torneo) }}">Editar</a>
                    <form action="{{ route('torneos.destroy', $torneo->id_torneo) }}" method="POST">
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
