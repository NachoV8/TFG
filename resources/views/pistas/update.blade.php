<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pista</title>
</head>
<body>
<h1>Editar Torneo</h1>

<div class="container">
<form action="{{ route('pistas.update', $pista->id_pista) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Nombre</label>
        </div>
        <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Last Name</label>
        </div>
    </div>
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" value="{{ $torneo->nombre }}"><br>

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
</div>
</body>
</html>


<div class="container">
    <div class="text">
        Contact us Form
    </div>
    <form action="#">
        <div class="form-row">
            <div class="input-data">
                <input type="text" required>
                <div class="underline"></div>
                <label for="">First Name</label>
            </div>
            <div class="input-data">
                <input type="text" required>
                <div class="underline"></div>
                <label for="">Last Name</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="text" required>
                <div class="underline"></div>
                <label for="">Email Address</label>
            </div>
            <div class="input-data">
                <input type="text" required>
                <div class="underline"></div>
                <label for="">Website Name</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data textarea">
                <textarea rows="8" cols="80" required></textarea>
                <br />
                <div class="underline"></div>
                <label for="">Write your message</label>
                <br />
                <div class="form-row submit-btn">
                    <div class="input-data">
                        <div class="inner"></div>
                        <input type="submit" value="submit">
                    </div>
                </div>
    </form>
</div>
