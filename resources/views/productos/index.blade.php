@extends('layouts.layout')

@section('contenido')

    <div class="tienda">
        <div class="filtros">
            <h3>Filtrar por tipo:</h3><br>
            <input type="checkbox" id="pala" name="producto" value="pala">
            <label for="pala">Palas</label><br>
            <input type="checkbox" id="pelota" name="producto" value="pelota">
            <label for="pelota">Pelotas</label><br>
            <input type="checkbox" id="grip" name="producto" value="grip">
            <label for="grip">Grips</label><br>
            <input type="checkbox" id="cinta" name="producto" value="cinta">
            <label for="cinta">Cintas</label><br>
            <input type="checkbox" id="mochila" name="producto" value="mochila">
            <label for="mochila">Mochilas</label><br>
        </div>
        <div class="productos">
            @foreach($productos->chunk(4) as $chunk)
                <div class="productosL">
                    @foreach($chunk as $producto)
                        <div class="producto" data-tipo="{{ $producto->tipo }}">
                            <img src="{{ asset('imagenes/tienda/Pala.png') }}" alt="Dibujo Pala Padel">
                            <h2>{{ $producto->nombre }}</h2>
                            <p>{{ $producto->precio }} €</p>
                            <button>Reservar</button>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    @if(Auth::check() && Auth::user()->rol == 3)

        <a href="{{route('productos.create')}}"><button>Nuevo Producto</button></a>

    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Precio</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($productosAll as $producto)
            <tr>
                <td>{{ $producto->id_producto }}</td>
                <td>{{ $producto->precio }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->cantidad }}</td>
                <td>{{ $producto->tipo }}</td>
                <td>
                    <a href="{{ route('productos.show', $producto->id_producto) }}">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @endif

    <script>
        // Obtener todos los checkboxes de tipo producto
        const checkboxes = document.querySelectorAll('input[name="producto"]');

        // Agregar un event listener a cada checkbox
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Array para almacenar los tipos seleccionados
                const tiposSeleccionados = [];

                // Iterar sobre todos los checkboxes y agregar los tipos seleccionados al array
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        tiposSeleccionados.push(checkbox.value);
                    }
                });

                // Obtener todos los productos
                const productos = document.querySelectorAll('.producto');

                // Iterar sobre todos los productos y mostrar/ocultar según los tipos seleccionados
                productos.forEach(function(producto) {
                    const tipoProducto = producto.dataset.tipo;

                    if (tiposSeleccionados.length === 0 || tiposSeleccionados.includes(tipoProducto)) {
                        producto.style.display = 'block'; // Mostrar el producto
                    } else {
                        producto.style.display = 'none'; // Ocultar el producto
                    }
                });
            });
        });
    </script>

@endsection
