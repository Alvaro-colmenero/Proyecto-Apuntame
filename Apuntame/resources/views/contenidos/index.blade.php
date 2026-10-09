
@extends('layouts.app')

@section('title', 'Catálogo | Cine y Series')

@section('content')

    <h1>Catálogo</h1>
    <p>Explora las películas y series disponibles.</p>

    <div class="filtros">
        <a href="{{ route('contenidos.index') }}"
           class="boton {{ !$tipo ? 'activo' : '' }}">
            Todo
        </a>

        <a href="{{ route('contenidos.index', ['tipo' => 'pelicula']) }}"
           class="boton {{ $tipo === 'pelicula' ? 'activo' : '' }}">
            Películas
        </a>

        <a href="{{ route('contenidos.index', ['tipo' => 'serie']) }}"
           class="boton {{ $tipo === 'serie' ? 'activo' : '' }}">
            Series
        </a>
    </div>

    @if ($contenidos->isEmpty())
        <p>No hay contenidos para mostrar.</p>
    @else

        <div class="catalogo">
            @foreach ($contenidos as $contenido)
                <article class="tarjeta">

                    @if ($contenido->imagen)
                        <img
                            src="{{ $contenido->imagen }}"
                            alt="{{ $contenido->titulo }}"
                            loading="lazy"
                        >
                    @else
                        <div class="sin-imagen">
                            Sin imagen
                        </div>
                    @endif

                    <div class="contenido-tarjeta">
                        <h2>{{ $contenido->titulo }}</h2>

                        <span class="etiqueta">
                        {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
                    </span>

                        @if ($contenido->fecha_estreno)
                            <p>
                                Estreno:
                                {{ \Carbon\Carbon::parse($contenido->fecha_estreno)->format('d/m/Y') }}
                            </p>
                        @endif

                        @if ($contenido->tipo === 'pelicula' && $contenido->duracion)
                            <p>{{ $contenido->duracion }} minutos</p>
                        @endif

                        <div>
                            @foreach ($contenido->generos as $genero)
                                <span class="etiqueta">
                                {{ $genero->nombre }}
                            </span>
                            @endforeach
                        </div>

                        <p>
                            {{ \Illuminate\Support\Str::limit($contenido->descripcion, 100) }}
                        </p>

                        <a class="boton"
                           href="{{ route('contenidos.show', $contenido) }}">
                            Ver detalles
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

        <div class="paginacion">
            {{ $contenidos->links() }}
        </div>

    @endif

@endsection
