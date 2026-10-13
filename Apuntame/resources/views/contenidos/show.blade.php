
@extends('layouts.app')

@section('title', $contenido->titulo . ' | MiCineSeries')

@section('content')

    <p>
        <a class="boton boton-secundario"
           href="{{ route('contenidos.index') }}">
            ← Volver al catálogo
        </a>
    </p>

    <article class="detalle">
        <div class="banner"
             @if ($contenido->banner || $contenido->poster)
                 style="background-image: url('{{ asset($contenido->banner ?: $contenido->poster) }}')"
            @endif>
        </div>

        <div class="detalle-contenido">
            @if ($contenido->poster)
                <img class="detalle-poster"
                     src="{{ asset($contenido->poster) }}"
                     alt="Póster de {{ $contenido->titulo }}">
            @else
                <div class="detalle-poster poster-vacio">
                    {{ $contenido->titulo }}
                </div>
            @endif

            <div class="detalle-texto">
            <span class="etiqueta">
                {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
            </span>

                <h1>{{ $contenido->titulo }}</h1>

                <p class="descripcion">
                    {{ $contenido->fecha_estreno
                        ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y')
                        : 'Año desconocido' }}

                    @if ($contenido->tipo === 'pelicula' && $contenido->duracion)
                        · {{ $contenido->duracion }} minutos
                    @elseif ($contenido->tipo === 'serie')
                        · {{ $contenido->estado_serie }}
                    @endif
                </p>

                <p class="descripcion">
                    {{ $contenido->descripcion ?: 'No hay descripción disponible.' }}
                </p>

                <div>
                    @forelse ($contenido->generos as $genero)
                        <span class="etiqueta">{{ $genero->nombre }}</span>
                    @empty
                        <span class="descripcion">Sin géneros asignados.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </article>

    @if ($contenido->tipo === 'serie')
        <section class="seccion">
            <div class="titulo-seccion">
                <h2>TEMPORADAS Y EPISODIOS</h2>
            </div>

            @forelse ($contenido->temporadas as $temporada)
                <div class="temporada">
                    <h3>
                        Temporada {{ $temporada->numero }}
                        @if ($temporada->titulo)
                            — {{ $temporada->titulo }}
                        @endif
                    </h3>

                    @if ($temporada->episodios->isEmpty())
                        <p class="descripcion">No hay episodios registrados.</p>
                    @else
                        <ul>
                            @foreach ($temporada->episodios as $episodio)
                                <li>
                                    Episodio {{ $episodio->numero }}:
                                    {{ $episodio->titulo }}

                                    @if ($episodio->duracion)
                                        · {{ $episodio->duracion }} min
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <p class="descripcion">
                    Esta serie todavía no tiene temporadas registradas.
                </p>
            @endforelse
        </section>
    @endif

@endsection
