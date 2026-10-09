
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cine y Series')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f5;
            color: #222;
        }

        header {
            background: #20232a;
            color: white;
            padding: 18px 7%;
        }

        header a {
            color: white;
            text-decoration: none;
            font-size: 22px;
            font-weight: bold;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .filtros {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .boton {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 6px;
            background: #e1e1e5;
            color: #222;
            text-decoration: none;
            border: 0;
            cursor: pointer;
        }

        .boton.activo {
            background: #303846;
            color: white;
        }

        .catalogo {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 22px;
        }

        .tarjeta {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px #00000012;
        }

        .tarjeta img {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .sin-imagen {
            height: 280px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #dddde2;
            color: #555;
        }

        .contenido-tarjeta {
            padding: 15px;
        }

        .contenido-tarjeta h2 {
            font-size: 18px;
            margin-top: 0;
        }

        .contenido-tarjeta p {
            color: #666;
            font-size: 14px;
        }

        .etiqueta {
            display: inline-block;
            background: #e9e9ee;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            margin: 2px;
        }

        .detalle {
            background: white;
            padding: 24px;
            border-radius: 10px;
        }

        .detalle-imagen {
            width: 220px;
            max-width: 100%;
            border-radius: 8px;
        }

        .temporada {
            padding: 15px 0;
            border-top: 1px solid #ddd;
        }

        .paginacion {
            margin-top: 25px;
        }

        .paginacion nav {
            display: flex;
            justify-content: center;
        }

        .paginacion nav > div {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .paginacion p {
            text-align: center;
        }

        @media (max-width: 600px) {
            main {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="{{ route('contenidos.index') }}">Cine y Series</a>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
