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
                    @foreach($clasesLibres as $clase)
                        <div class="clase-I1">
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
            </div>
        </div>
    @endif

@endsection
