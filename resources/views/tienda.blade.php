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
            <input type="checkbox" id="camiseta" name="producto" value="camiseta">
            <label for="camiseta">Camisetas</label><br>
            <input type="checkbox" id="mochila" name="producto" value="mochila">
            <label for="mochila">Mochilas</label><br>
        </div>
        <div class="productos">
            @foreach($productos->chunk(4) as $chunk)
                <div class="productosL">
                    @foreach($chunk as $producto)
                        <div class="producto">
                            <img src="{{ asset('imagenes/tienda/Pala.png') }}" alt="Dibujo Pala Padel">
                            <h2>{{ $producto->nombre }}</h2>
                            <p>{{ $producto->precio }}€</p>
                            <button>Comprar</button>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Precio</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($productos as $producto)
            <tr>
                <td>{{ $producto->id_producto }}</td>
                <td>{{ $producto->precio }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->cantidad }}</td>
                <td>
                    <a href="{{ route('productos.edit', $producto->id_producto) }}">Editar</a>
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

@endsection
