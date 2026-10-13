
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MiCineSeries')</title>


    <style>
        * {box-sizing: border-box;}
        body {margin: 0;background: #09151d;color: #edf5fa;font-family: Arial, sans-serif;}
        a {color: inherit;text-decoration: none;}
        header {min-height: 68px;padding: 16px 4%;display: flex;justify-content: space-between;align-items: center;gap: 20px;background: #0b1922;border-bottom: 1px solid #253744;}
        .logo {font-size: 23px;font-weight: bold;}
        .logo span {color: #25bfd0;}
        nav {display: flex;gap: 22px;color: #9eb3c2;}
        nav a:hover {color: #25bfd0;}
        main {width: 92%;max-width: 1600px;margin: 32px auto 60px;}
        .filtros {display: grid;grid-template-columns: 2fr repeat(3, 1fr) auto;gap: 14px;margin-bottom: 38px;}
        .campo label {display: block;margin-bottom: 9px;font-size: 13px;font-weight: bold;}
        input,
        select {width: 100%;min-width: 0;padding: 12px;background: #172630;color: #edf5fa;border: 1px solid #253744;border-radius: 7px;}
        input:focus,
        select:focus {outline: 2px solid #25bfd0;outline-offset: 2px;}
        .boton {display: inline-block;border: 0;border-radius: 7px;padding: 11px 15px;background: #25bfd0;color: #07151c;cursor: pointer;font-weight: bold;}
        .boton:hover {background: #5ad8e3;}
        .boton-secundario {background: #14212b;color: #edf5fa;}
        .boton-secundario:hover {background: #253744;}
        .seccion {margin: 30px 0 42px;}
        .titulo-seccion {display: flex;align-items: center;justify-content: space-between;gap: 12px;margin-bottom: 18px;}
        .titulo-seccion h2 {font-size: 18px;margin: 0;}
        .ver-todo {color: #25bfd0;font-size: 13px;}
        .ver-todo:hover {color: #5ad8e3;}
        .catalogo {display: grid;grid-template-columns: repeat(6, minmax(0, 1fr));gap: 20px;}
        .tarjeta {min-width: 0;overflow: hidden;background: #0d1b25;border: 1px solid #253744;border-radius: 9px;transition: transform 0.2s, border-color 0.2s;}
        .tarjeta:hover {transform: translateY(-4px);border-color: #25bfd0;}
        .poster {display: block;width: 100%;aspect-ratio: 2 / 3;object-fit: cover;background: #14212b;}
        .poster-vacio {display: grid;place-items: center;aspect-ratio: 2 / 3;padding: 12px;text-align: center;background: linear-gradient(140deg, #2a4050, #101a23);color: #9eb3c2;}
        .tarjeta-info {padding: 12px;}
        .tarjeta h3 {font-size: 14px;line-height: 1.4;margin: 0 0 8px;}
        .meta {font-size: 12px;color: #9eb3c2;margin-bottom: 9px;}
        .etiqueta {display: inline-block;margin: 2px;padding: 4px 8px;border-radius: 20px;background: #342d21;color: #ffc66d;font-size: 11px;}
        .descripcion {color: #9eb3c2;line-height: 1.7;}
        .paginacion {margin-top: 25px;}
        .paginacion nav {justify-content: center;flex-wrap: wrap;}
        .paginacion nav span,
        .paginacion nav a {display: inline-block;padding: 8px 12px;background: #14212b;border-radius: 5px;}
        .detalle {overflow: hidden;background: #14212b;border: 1px solid #253744;border-radius: 10px;}
        .banner {height: 340px;background-color: #20313d;background-size: cover;background-position: center 30%;position: relative;}

        .banner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, #14212b, rgba(20, 33, 43, 0.65) 45%, transparent 100%);
        }

        .detalle-contenido {display: flex;align-items: flex-start;gap: 28px;position: relative;z-index: 1;margin-top: -130px;padding: 0 28px 30px;}
        .detalle-poster {display: block;flex-shrink: 0;width: 210px;aspect-ratio: 2 / 3;object-fit: cover;border-radius: 7px;background: #20313d;}
        .detalle-texto {padding-top: 65px;min-width: 0;}
        .detalle-texto h1 {font-size: 32px;margin: 12px 0;}
        .temporada {padding: 16px 0;border-top: 1px solid #253744;}
        .temporada li {margin: 10px 0;color: #9eb3c2;}

        @media (max-width: 1100px) {
            .catalogo {grid-template-columns: repeat(4, minmax(0, 1fr));}
            .filtros {grid-template-columns: repeat(3, minmax(0, 1fr));}
        }

        @media (max-width: 650px) {
            header {flex-wrap: wrap;}
            nav {gap: 12px;font-size: 13px;flex-wrap: wrap;}
            .catalogo {grid-template-columns: repeat(2, minmax(0, 1fr));gap: 12px;}
            .filtros {grid-template-columns: repeat(2, minmax(0, 1fr));}
            .detalle-contenido {display: block;padding: 0 18px 22px;}
            .detalle-poster {width: 145px;}
            .detalle-texto {padding-top: 20px;}
            .detalle-texto h1 {font-size: 25px;}
            .banner {height: 220px;}
        }
    </style>

</head>
<body>
<header>
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
