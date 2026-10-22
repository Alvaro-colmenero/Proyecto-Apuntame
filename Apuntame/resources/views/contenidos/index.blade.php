@extends('layouts.app')
@section('title', 'Inicio | MiCineSeries')
@section('content')

    <form class="filtros" method="GET" action="{{ route('contenidos.index') }}">
        <div class="campo">
            <label for="buscar">Buscar</label>
            <input id="buscar" name="buscar" type="search" value="{{ $busqueda }}" placeholder="Buscar título...">
        </div>

        <div class="campo">
            <label for="tipo">Formato</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="pelicula" @selected($tipo === 'pelicula')>Películas</option>
                <option value="serie" @selected($tipo === 'serie')>Series</option>
            </select>
        </div>

        <div class="campo">
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                @foreach ($generos as $genero)
                    <option value="{{ $genero->id }}"
                        @selected((string) $generoId === (string) $genero->id)>
                        {{ $genero->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="campo">
            <label for="anio">Año</label>
            <select id="anio" name="anio">
                <option value="">Todos</option>
                @foreach ($anios as $a)
                    <option value="{{ $a }}"
                        @selected((string) $anio === (string) $a)>
                        {{ $a }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="campo">
            <label>&nbsp;</label>
            <button class="boton" type="submit">Filtrar</button>
        </div>
    </form>

    @if ($busqueda || $tipo || $generoId || $anio)
        <section class="seccion">
            <div class="titulo-seccion">
                <h2>RESULTADOS</h2>
                <a class="ver-todo" href="{{ route('contenidos.index') }}">
                    Limpiar filtros
                </a>
            </div>

            @include('contenidos._tarjetas', ['lista' => $contenidos->getCollection()])

            <div class="paginacion">{{ $contenidos->links() }}</div>
        </section>
    @else
        <section class="seccion">
            <div class="titulo-seccion">
                <h2>TENDENCIAS</h2>
                <a class="ver-todo" href="{{ route('contenidos.index') }}">Ver catálogo →</a>
            </div>

            @include('contenidos._tarjetas', ['lista' => $contenidos->getCollection()->take(6)])
        </section>

        <section class="seccion">
            <div class="titulo-seccion">
                <h2>PELÍCULAS Y SERIES</h2>
                <a class="ver-todo" href="{{ route('contenidos.index') }}">Ver todo →</a>
            </div>

            @include('contenidos._tarjetas', ['lista' => $contenidos->getCollection()->slice(12, 12)])
        </section>

        <div class="paginacion">{{ $contenidos->links() }}</div>
    @endif

@endsection
