@extends("layouts.layout")

@section('contenido')

    <form action="{{route('productos.update', $producto->id_producto)}}" method="POST">
        @csrf
        <!--PATCH se utiliza para los update (php artisan route:list --name=alumno)-->
        @method("PATCH")
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="{{$producto->nombre}}"/>

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" value="{{$producto->cantidad}}"/>

        <label for="precio">Precio</label>
        <input type="number" name="precio" value="{{$producto->precio}}"/>

        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" value="{{$producto->tipo}}"/>

        <button>Actualizar</button>
    </form>
@endsection

