<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Torneo</title>
</head>
<body>
<h1>Crear Torneo</h1>

<form action="{{ route('torneos.store') }}" method="POST">
    @csrf

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre"><br>

    <label for="descripcion">Descripción:</label><br>
    <input type="text"  name="descripcion"><br>

    <label for="premios">Premios:</label><br>
    <input type="text" name="premios"><br>

    <label for="precio">Precio:</label><br>
    <input type="number" name="precio"><br>

    <label for="cant_max">Cantidad Máxima de Jugadores:</label><br>
    <input type="number" name="cant_max"><br>

    <label for="hora_inicio">Fecha de Inicio:</label><br>
    <input type="time"  name="hora_inicio"><br>

    <label for="hora_fin">Fecha de Fin:</label><br>
    <input type="time" name="hora_fin"><br>

    <label for="pista">Pista:</label><br>
    <input type="number" name="pista"><br>


    <button type="submit">Crear</button>

</form>

</body>
</html>
