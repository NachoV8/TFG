@extends('layouts.layout')

@section('contenido')
    <div class="todo">
        <div class="info-1">
            <h2>Quiénes Somos</h2>
            <div class="info-a">
                <h4>Inicios</h4>
                <p>
                    Hace unos años, en un pequeño pueblo donde el pádel apenas comenzaba a ganar popularidad,
                    tres amigos jóvenes decidieron unir sus pasiones y emprendimiento para crear algo único en su comunidad.
                    Pablo, Carlos y Marta, todos amantes del pádel desde muy jóvenes, soñaban con tener un lugar donde la
                    gente pudiera disfrutar del deporte que tanto los apasionaba. <br><br>

                    Con determinación y entusiasmo, los tres amigos pusieron manos a la obra.
                    Utilizando sus ahorros y con la ayuda de sus familias, alquilaron un terreno abandonado en las afueras del pueblo y comenzaron a construir.
                    Armados con palas, rastrillos y mucha creatividad, convirtieron el terreno en unas hermosas pistas de pádel.
                </p>
            </div>
            <div class="info-b">
                <h4>Objetivos</h4>
                <p>Pero su visión iba más allá de simples pistas. Querían crear un espacio donde la comunidad pudiera reunirse, aprender y competir.
                    Así que además de las pistas, construyeron una pequeña sala de clases donde ofrecían lecciones para principiantes y jugadores más avanzados.
                    Organizaban torneos locales que reunían a jugadores de todas las edades y niveles, fomentando la competencia sana y el compañerismo entre los vecinos.
                </p>
            </div>
            <div class="info-c">
                <h4>Reglas</h4>
                <p>Con el tiempo, el pequeño centro de pádel se convirtió en el corazón del pueblo.
                    Era el lugar donde la gente se encontraba después del trabajo para disfrutar de un partido rápido,
                    donde los niños aprendían los fundamentos del deporte y donde se forjaban amistades que durarían toda la vida.
                    La iniciativa de Pablo, Carlos y Marta no solo creó un espacio para jugar al pádel,
                    sino que también creó una comunidad unida y apasionada por el deporte. <br> <br>

                    Con el tiempo, el pequeño centro de pádel se convirtió en el corazón del pueblo.
                    Era el lugar donde la gente se encontraba después del trabajo para disfrutar de un partido rápido,
                    donde los niños aprendían los fundamentos del deporte y donde se forjaban amistades que durarían toda la vida.
                    La iniciativa de Pablo, Carlos y Marta no solo creó un espacio para jugar al pádel,
                    sino que también creó una comunidad unida y apasionada por el deporte.

                    <br> <br>

                    Con el tiempo, el pequeño centro de pádel se convirtió en el corazón del pueblo.
                    Era el lugar donde la gente se encontraba después del trabajo para disfrutar de un partido rápido,
                    donde los niños aprendían los fundamentos del deporte y donde se forjaban amistades que durarían toda la vida.
                    La iniciativa de Pablo, Carlos y Marta no solo creó un espacio para jugar al pádel,
                    sino que también creó una comunidad unida y apasionada por el deporte.
                </p>
            </div>
        </div>
        <div class="info-2">
            <div class="info-d">
                <h2>Dónde estamos</h2>
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=Padel+Indoor+Turiaso&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://online-timer.me/"></a><br><a href="https://online.stopwatch-timer.net/"></a>
                    </div>
                </div>
            </div>
            <div class="info-e">
                <h2>¿Alguna Duda?</h2>
                <div class="formulario">

                    @if(auth()->check())

                    <form action="{{route('contactos.store')}}" method="POST">
                        @csrf


                        <input type="hidden" id="nombre" name="nombre" value="{{ auth()->user()->name }}">
                        <input type="hidden" id="email" name="email" value="{{ auth()->user()->email }}">

                        <label for="motivo">Motivo:</label><br>
                        <input type="text" id="motivo" name="motivo" required><br><br>

                        <label for="mensaje">Descripción del Mensaje:</label><br>
                        <textarea id="mensaje" name="mensaje" rows="4" cols="50" required></textarea><br><br>


                        <button class="botonE" type="submit">Enviar</button>

                        @else

                            <p>Necesitas estar autenticado</p>

                        @endif
                        @if(session('info'))
                            <script>
                                alert("{{session('info')}}")
                            </script>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
