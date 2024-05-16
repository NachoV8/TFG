<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pista</title>
</head>
<body>
<h1>Editar Torneo</h1>

<form action="{{ route('sesiones.update', $sesion->id_sesion) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" value="{{ $sesion->nombre }}"><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion">{{ $torneo->descripcion }}</textarea><br>

    <label for="premios">Premios:</label><br>
    <textarea id="premios" name="premios">{{ $torneo->premios }}</textarea><br>

    <label for="precio">Precio:</label><br>
    <textarea id="precio" name="precio">{{ $torneo->precio }}</textarea><br>

    <label for="cant_max">Cantidad Máxima de Jugadores:</label><br>
    <input type="number" id="cant_max" name="cant_max" value="{{ $torneo->cant_max }}"><br>

    <label for="hora_inicio">Fecha de Inicio:</label><br>
    <input type="time" id="hora_inicio" name="hora_inicio" value="{{ $torneo->hora_inicio }}"><br>

    <label for="hora_fin">Fecha de Fin:</label><br>
    <input type="time" id="hora_fin" name="hora_fin" value="{{ $torneo->hora_fin }}"><br>

    <label for="pista">Pista:</label><br>
    <textarea id="pista" name="pista">{{ $torneo->pista }}</textarea><br>

    <button type="submit">Actualizar</button>

</form>

</body>
</html>
