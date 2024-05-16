@extends("layouts.layout")

@section("contenido")
    <div class="flex items-center justify-center h-full p-5 rounded-2xl">
        <div class="w-full max-w-md h-full">
            <!--Los campos van con la información del alumno que recibe-->
            <!--Cuando se acepte el form se pasa a la ruta de update-->
            <form action="{{route('clases.update', $clase->id_clase)}}" method="POST">
                @csrf
                <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
                @method("PATCH")


                <label for="id_profesor">Id Profesor</label>
                <select name="id_profesor" id="id_profesor">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ $clase->id_profesor == $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->name }}
                        </option>
                    @endforeach
                </select>
                <!--Enseña los errores-->
                <x-input-error class="mt-2" :messages="$errors->get('id_profesor')"/><br>

                <label for="pista">Pista:</label>
                <select name="pista" id="pista">
                    @foreach($pistasDisponibles as $pistaDisponible)
                        <option value="{{ $pistaDisponible->id_pista }}" {{ $clase->id_pista == $pistaDisponible->id_pista ? 'selected' : '' }}>
                            {{ $pistaDisponible->pista }} - {{ $pistaDisponible->fecha }} - {{ $pistaDisponible->hora_inicio }}
                        </option>
                    @endforeach
                </select>

                <x-input-error class="mt-2" :messages="$errors->get('pista')"/><br>


                <label for="alumno">Alumno</label>
                <input type="number" name="alumno" value="{{$clase->id_alumno}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('id_alumno')"/><br>


                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" value="{{$clase->descripcion}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/><br>


                <label for="precio">Precio</label>
                <input type="number" name="precio" value="{{$clase->precio}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>


                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection