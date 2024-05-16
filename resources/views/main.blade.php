@extends('layouts.layout')

@section('contenido')

    <div class="cuerpo">
        <div class="info-I1">
            <div class="info-Ia">
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
            <div class="info-Ib">
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
        <div class="info-I2">
            <h2>Clases Disponibles</h2>
            <div class="clasesI">
                <div class="clase-I1">
                    <h4>Andreu</h4>
                    <p>LLega uno de nuestros mejores jugadores a
                        enseñarte sus mejores tácticas para ganar
                        todos los puntos!
                    </p>
                    <p>Martes: 17:30 y Jueves: 19:00</p>
                    <div class="boton"><button>Disponibilidad</button></div>
                </div>
                <div class="clase-I1">
                    <h4>Jorge</h4>
                    <p>Desde Zaragoza viene a dar sus mejores lecciones
                        el campeón de Aragón 2023!
                    </p>
                    <p>Miercoles: 17:30 y Viernes: 20:30</p>
                    <div class="boton"><button>Disponibilidad</button></div>
                </div>
                <div class="clase-I1">
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
    </div>

@endsection
