@extends("layouts.layout")

@section("contenido")

    <h2>Insertar Producto</h2>

    <div class="formulario-insertar-producto">
        <form action="{{route('productos.store')}}" method="POST">

            @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->


            <label for="nombre">Nombre</label>
            <input type="text" name="nombre"/>
            <x-input-error class="mt-2" :messages="$errors->get('nombre')"/><br>


            <label for="precio">Precio</label>
            <input type="number" name="precio"/>
            <x-input-error class="mt-2" :messages="$errors->get('precio')"/><br>


            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad"/>
            <x-input-error class="mt-2" :messages="$errors->get('cantidad')"/><br>


            <div class="form-group">
                <label for="tipo">Tipo de producto:</label>
                <select name="tipo" id="tipo" class="form-control">
                    @foreach($tiposProductos as $key => $tipo)
                        <option value="{{ $key }}">{{ $tipo }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('tipo')"/><br>
            </div>


            <button>Enviar</button>
        </form>
    </div>

@endsection
