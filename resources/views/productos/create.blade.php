<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Torneo</title>
</head>
<body>
    <h1>Insertar Producto</h1>

    <form action="{{route('productos.store')}}" method="POST">
        @csrf <!--Token para asegurarnos de que el formulario que se ejecuta es nuestro y no un ataque-->
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre"/>

        <label for="precio">Precio</label>
        <input type="number" name="precio"/>

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad"/>

        <div class="form-group">
            <label for="tipo">Tipo de producto:</label>
            <select name="tipo" id="tipo" class="form-control">
                @foreach($tiposProductos as $key => $tipo)
                    <option value="{{ $key }}">{{ $tipo }}</option>
                @endforeach
            </select>
        </div>


        <button>Enviar</button>
    </form>

</body>
</html>
