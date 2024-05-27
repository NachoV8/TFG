@extends("layouts.layout")

@section('contenido')

    <div>
        <h3>Modificar Reserva</h3>
        <div class="formulario-editar-productos">

            <form action="{{route('reservas.update', $reserva->id_reserva)}}" method="POST">
                @csrf
                <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
                @method("PATCH")

                <label for="name">{{ $reserva->usuario->email }}</label>

                <label for="nombre">{{ $reserva->producto->nombre }}</label>

                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" value="{{$reserva->cantidad}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('cantidad')"/><br>

                <label for="stock">Stock: {{ $reserva->producto->cantidad }}</label>

                @error('error')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection

