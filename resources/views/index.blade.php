@extends('layouts.layout')

@section('contenido')

    @if(Auth::check() && Auth::user()->rol == 3)
        <h2>Hola de nuevo! {{ Auth::user()->name }}</h2>
    @else
        <div class="cuerpo">
            <div class="info-I1">
                <div class="info-Ia">
                    <h2>Torneo XAB</h2>
                    <div class="texto">
                        <div class="left">
                            <p>Torneo modelo tradicional en el que habrá desde partido desde octavos!</p>
                            <p>Juega 2 partidos asegurados!</p>
                            <p>12 € p.p.</p>
                        </div>
                        <div class="right">
                            <p class="first">1º Pala BullPadel</p>
                            <p class="second">2º Pack 3 botes pelotas HEAD</p>
                            <p class="third">3º 2 Grips</p>
                        </div>
                    </div>
                    <div class="boton">
                        <a href="/torneos"><button class="button-torneo" role="button">Apúntate</button></a>
                    </div>
                </div>

                <div class="info-Ia">
                    <h2>Torneo Americano</h2>
                    <div class="texto">
                        <div class="left">
                            <p>Torneo modelo tradicional en el que habrá desde partido desde octavos!</p>
                            <p>Juega 2 partidos asegurados!</p>
                            <p>12 € p.p.</p>
                        </div>
                        <div class="right">
                            <p class="first">1º Pala BullPadel</p>
                            <p class="second">2º Pack 3 botes pelotas HEAD</p>
                            <p class="third">3º 2 Grips</p>
                        </div>
                    </div>
                    <div class="boton">
                        <a href="/torneos"><button class="button-torneo" role="button">Apúntate</button></a>
                    </div>
                </div>
            </div>
            <div class="info-I2">
                <h2>Clases Disponibles</h2>
                <div class="clasesI">
                    <div class="clase-I1">
                        <h3>Andreu</h3>
                        <p>Llega uno de nuestros mejores jugadores a enseñarte sus mejores tácticas para ganar todos los puntos!</p>
                        <p>Martes: 17:30 y Jueves: 19:00</p>
                        <div class="boton">
                            <a href="/clases"><button class="button-clases">Disponibilidad</button></a>
                        </div>
                    </div>
                    <div class="clase-I1">
                        <h3>Jorge</h3>
                        <p>Desde Zaragoza viene a dar sus mejores lecciones el campeón de Aragón 2023!</p>
                        <p>Miércoles: 17:30 y Viernes: 20:30</p>
                        <div class="boton">
                            <a href="/clases"><button class="button-clases">Disponibilidad</button></a>
                        </div>
                    </div>
                    <div class="clase-I1">
                        <h3>Andreu</h3>
                        <p>Llega uno de nuestros mejores jugadores a enseñarte sus mejores tácticas para ganar todos los puntos!</p>
                        <p>Lunes: 16:00 y Miércoles: 19:00</p>
                        <div class="boton">
                            <a href="/clases"><button class="button-clases">Disponibilidad</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
