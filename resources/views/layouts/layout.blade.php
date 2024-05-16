<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sobre-nosotros.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pistas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/torneos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clases.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">


    <title>Document</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="../"><img src="{{ asset('imagenes/Logo.png') }}" alt="Logo Pade Indoor"></a>
        </div>
        <div class="nav">
            <a class="pistasL" href="../pistas">pistas</a>
            <a class="torneosL" href="torneos">torneos</a>
            <a class="clasesL" href="../clases">clases</a>
            <a class="tiendaL" href="../productos">tienda</a>
            <a class="sobre-nosotrso" href="../sobre-nosotros">Sobre Nosotros</a>
        @guest
            <a href="../login">Log In</a>
            <a href="../register">Sing In</a>
            @else
            <a href="../perfil">{{ Auth::user()->name }}    </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout" type="submit">Logout</button>
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
