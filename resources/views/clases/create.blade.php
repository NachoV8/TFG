@extends("layouts.layout")

@section("contenido")

    <div class="crear-clase">

        <h2>CREAR CLASE</h2>

        <div class="formulario-crear-clase">
            <!--Formulario para crear una nueva clase-->
            <form action="{{ route('clases.store') }}" method="POST">
                @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->

                <!-- Campo para el ID del profesor -->
                <label for="id_profesor">Profesor:</label>
                <select name="id_profesor" id="id_profesor">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_profesor')"/><br>


                <!-- Campo para el precio -->
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio">
                <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>


                <!-- Campo para la descripción -->
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="5"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/><br>


                <!-- Campo para seleccionar la pista -->
                <label for="pista">Pista:</label>
                <select name="pista" id="pista">
                    @foreach($pistasDisponibles as $pista)
                        <option value="{{ $pista->id_pista }}">{{ $pista->pista }} - {{ $pista->fecha }} - {{ $pista->hora_inicio }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('pista')"/><br>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!-- Botón de Enviar -->
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

@endsection
