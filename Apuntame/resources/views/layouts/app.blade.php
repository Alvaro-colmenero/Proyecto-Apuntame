<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MiCineSeries')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>
<header>
    <div class="auth-nav">
        @guest
            <a class="nav-auth-link" href="{{ route('login') }}">Iniciar sesión</a>
            <a class="nav-auth-link nav-auth-primary" href="{{ route('registro') }}">Crear cuenta</a>
        @else
            <a class="nav-auth-link" href="{{ route('perfil.index') }}">Mi perfil</a>

            <form class="nav-logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-auth-link nav-logout-button" type="submit">Cerrar sesión</button>
            </form>
        @endguest
    </div>

    <a class="logo" href="{{ route('contenidos.index') }}">
        <span>Apuntame</span>
    </a>

    <nav>
        <a href="{{ route('contenidos.index') }}">Inicio</a>
        <a href="{{ route('contenidos.index', ['tipo' => 'pelicula']) }}">Películas</a>
        <a href="{{ route('contenidos.index', ['tipo' => 'serie']) }}">Series</a>
    </nav>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
