@extends('layouts.layout')

@section('contenido')
    <h2>Clases Disponibles</h2>
    <div class="clases">
        <div class="clasesF">
            <div class="clase">
                <h4>Andreu</h4>
                <p>LLega uno de nuestros mejores jugadores a
                    enseñarte sus mejores tácticas para ganar
                    todos los puntos!
                </p>
                <p>Martes: 17:30 y Jueves: 19:00</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
            <div class="clase">
                <h4>Jorge</h4>
                <p>Desde Zaragoza viene a dar sus mejores lecciones
                    el campeón de Aragón 2023!
                </p>
                <p>Miercoles: 17:30 y Viernes: 20:30</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
            <div class="clase">
                <h4>Andreu</h4>
                <p>LLega uno de nuestros mejores jugadores a
                    enseñarte sus mejores tácticas para ganar
                    todos los puntos!
                </p>
                <p>Lunes: 16:00 y Miercoles: 19:00</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
        </div>
        <div class="clasesF">
            <div class="clase">
                <h4>Andreu</h4>
                <p>LLega uno de nuestros mejores jugadores a
                    enseñarte sus mejores tácticas para ganar
                    todos los puntos!
                </p>
                <p>Martes: 17:30 y Jueves: 19:00</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
            <div class="clase">
                <h4>Jorge</h4>
                <p>Desde Zaragoza viene a dar sus mejores lecciones
                    el campeón de Aragón 2023!
                </p>
                <p>Miercoles: 17:30 y Viernes: 20:30</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
            <div class="clase">
                <h4>Andreu</h4>
                <p>LLega uno de nuestros mejores jugadores a
                    enseñarte sus mejores tácticas para ganar
                    todos los puntos!
                </p>
                <p>Lunes: 16:00 y Miercoles: 19:00</p>
                <div class="boton"><button>Disponibilidad</button></div>
            </div>
        </div>
    </div>

    <table border="1">
        <thead>
        <tr>
            <th>Id_clase</th>
            <th>Id_Profesor</th>
            <th>id_Pista</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Hora de Inicio</th>
            <th>fecha_clase</th>
            <th>Acciones</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($clases as $clase)
            <tr>
                <td>{{ $clase->id_clase }}</td>
                <td>{{ $clase->id_profesor }}</td>
                <td>{{ $clase->id_pista }}</td>
                <td>{{ $clase->descripcion }}</td>
                <td>{{ $clase->precio }}</td>
                <td>{{ $clase->hora_inicio }}</td>
                <td>{{ $clase->fecha_clase }}</td>
                <td>
                    <a href="{{ route('clases.show', $clase->id_clase) }}">Ver Detalles</a>
                    <a href="{{ route('clases', $clase->id_clase) }}">Editar</a>
                    <form action="{{ route('clases.destroy', $clase->id_clase) }}" method="POST">
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
