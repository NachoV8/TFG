@extends('layouts.layout')

@section('contenido')

    @if(Auth::check() && Auth::user()->rol == 3)
        <h2 class="titulo-admin">Hola de nuevo! {{ Auth::user()->name }}</h2>
    @else
        <div class="cuerpo">
            <h1>PADEL INDOOR TURIASO</h1>
            <div class="info-I1">
                @foreach($torneosCercanos as $torneo)
                    <div class="info-Ia">
                        <h3>{{ $torneo->nombre }}</h3>
                        <div class="texto">
                            <div class="left">
                                <p class>{{ $torneo->descripcion }}</p>
                                <p>{{ $torneo->precio }} € p.p.</p>
                                <p>{{ $torneo->fecha }}</p>
                                <p>Hora de inicio: {{ $torneo->hora_inicio }}</p>
                            </div>
                            <div class="right">
                                <p class="first">{{ $torneo->premios }}</p>
                            </div>
                        </div>
                        <div class="inscripciones">
                            <p>Inscritos: {{ $torneo->inscritos }} / {{ $torneo->cant_max }}</p>
                        </div>
                        <button class="button-torneo" role="button" onclick="location.href='/torneos'">Apúntate</button>
                    </div>
                @endforeach
            </div>
            <div class="info-I2">
                <h2>Clases Disponibles</h2>
                <div class="clasesI">
                    @foreach($clasesLibres as $clase)
                        <div class="clase-I1">
                            <h3>{{ $clase->profesor->name }}</h3>
                            <p>{{ $clase->descripcion }}</p>
                            <div class="info-clase">
                                <p>{{ $clase->precio }}€</p>
                                <p>{{ $clase->fecha }}</p>
                                <p>{{ $clase->hora_inicio }}</p>
                            </div>
                            <button class="button-clases" role="button" onclick="location.href='/clases'">Apúntate</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection
