
@extends('layouts.app')

@section('title', $contenido->titulo . ' | Cine y Series')

@section('content')

    <p>
        <a class="boton" href="{{ route('contenidos.index') }}">
            ← Volver al catálogo
        </a>
    </p>

    <div class="detalle">

        @if ($contenido->imagen)
            <img
                class="detalle-imagen"
                src="{{ $contenido->imagen }}"
                alt="{{ $contenido->titulo }}"
            >
        @endif

        <h1>{{ $contenido->titulo }}</h1>

        <p>
        <span class="etiqueta">
            {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
        </span>
        </p>

        <p>
            <strong>Fecha de estreno:</strong>
            {{ $contenido->fecha_estreno
                ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('d/m/Y')
                : 'No disponible' }}
        </p>

        @if ($contenido->tipo === 'pelicula')
            <p>
                <strong>Duración:</strong>
                {{ $contenido->duracion
                    ? $contenido->duracion . ' minutos'
                    : 'No disponible' }}
            </p>
        @else
            <p>
                <strong>Estado:</strong>
                {{ $contenido->estado_serie }}
            </p>
        @endif

        <h3>Descripción</h3>
        <p>{{ $contenido->descripcion ?: 'Sin descripción disponible.' }}</p>

        <h3>Géneros</h3>

        @forelse ($contenido->generos as $genero)
            <span class="etiqueta">{{ $genero->nombre }}</span>
        @empty
            <p>No hay géneros asignados.</p>
        @endforelse

        @if ($contenido->tipo === 'serie')
            <h2>Temporadas y episodios</h2>

            @forelse ($contenido->temporadas as $temporada)
                <section class="temporada">

                    <h3>
                        Temporada {{ $temporada->numero }}
                        @if ($temporada->titulo)
                            - {{ $temporada->titulo }}
                        @endif
                    </h3>

                    @if ($temporada->episodios->isEmpty())
                        <p>No hay episodios registrados.</p>
                    @else
                        <ul>
                            @foreach ($temporada->episodios as $episodio)
                                <li>
                                    Episodio {{ $episodio->numero }}:
                                    {{ $episodio->titulo }}

                                    @if ($episodio->duracion)
                                        ({{ $episodio->duracion }} min)
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </section>
            @empty
                <p>Esta serie todavía no tiene temporadas registradas.</p>
            @endforelse
        @endif

    </div>

@endsection
