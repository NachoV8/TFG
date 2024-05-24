<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pistas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sobre-nosotros.css') }}">
    <link rel="stylesheet" href="{{ asset('css/torneos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clases.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Document</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="../"><img src="{{ asset('imagenes/Logo.png') }}" alt="Logo Pade Indoor"></a>
        </div>
        <div class="nav">
            @if(Auth::check() && Auth::user()->rol == 3)
                <a class="pistasL" href="../pistas">PISTAS</a>
                <a class="torneosL" href="../torneos">TORNEOS</a>
                <a class="clasesL" href="../clases">CLASES</a>
                <a class="tiendaL" href="../productos">TIENDA</a>
            @else
                <a class="pistasL" href="../pistas">PISTAS</a>
                <a class="torneosL" href="../torneos">TORNEOS</a>
                <a class="clasesL" href="../clases">CLASES</a>
                <a class="tiendaL" href="../productos">TIENDA</a>
                <a class="sobre-nosotrso" href="../sobre-nosotros">SOBRE NOSOTROS</a>

            @endif

        @guest
            <a href="../login"><button class="button-login" role="button">Log in</button></a>
            @else
            <div class="nombre">
                <a href="../perfil"><img src="/imagenes/perfil/Pelota.png" alt="Pelota padel">
                <p>{{ Auth::user()->name }} </p></a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="button-logout" type="submit">Logout</button>
            </form>
        @endguest
        </div>
    </div>

    @yield('contenido') @section('contenido')


    <footer>
        <p>padelindoorturiaso</p>
    </footer>

</body>
</html>



