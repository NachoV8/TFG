@extends("layouts.layout")

@section('contenido')

    <div class="editar-producto">
        <h2>Modificar Producto</h2>
        <div class="formulario-editar-productos">

            <form action="{{route('productos.update', $producto->id_producto)}}" method="POST">
                @csrf
                <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
                @method("PATCH")
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value="{{$producto->nombre}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('nombre')"/><br>

                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" min="0" value="{{$producto->cantidad}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('cantidad')"/><br>

                <label for="precio">Precio</label>
                <input type="number" name="precio" min="0" value="{{$producto->precio}}"/>
                <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>

                <div class="form-group">
                    <label for="tipo">Tipo de producto:</label>
                    <select name="tipo" id="tipo" class="form-control">
                        @foreach($tiposProductos as $key => $value)
                            <option value="{{ $key }}" {{ $producto->tipo == $key ? 'selected' : '' }}>
                                {{ ucfirst($value) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('tipo')"/><br>
                </div>

                <button>Actualizar</button>
            </form>
        </div>
    </div>
@endsection

