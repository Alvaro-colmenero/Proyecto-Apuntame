@extends('layouts.app')
@section('title', $contenido->titulo . ' | MiCineSeries')
@section('content')

    @include('biblioteca.modal')

    <link rel="stylesheet" href="{{ asset('css/contenido_ver.css') }}">

    <div class="pagina-detalle">

        {{-- Navegación --}}
        <div class="detalle-navegacion">
            <a class="detalle-volver" href="{{ url()->previous() }}">
                <span>←</span> Volver al catálogo
            </a>
        </div>

        {{-- Cabecera visual --}}
        <div class="detalle-banner"
             @if ($contenido->banner || $contenido->poster)
                 style="background-image: url('{{ asset($contenido->banner ?: $contenido->poster) }}')"
            @endif>
            <div class="detalle-banner-overlay"></div>
        </div>

        {{-- Contenido principal --}}
        <article class="detalle-layout">

            {{-- COLUMNA IZQUIERDA --}}
            <aside class="detalle-sidebar">

                {{-- Póster --}}
                <div class="detalle-poster-wrapper">

                    @if ($contenido->poster)
                        <img
                            class="detalle-poster"
                            src="{{ asset($contenido->poster) }}"
                            alt="Póster de {{ $contenido->titulo }}"
                        >
                    @else
                        <div class="detalle-poster poster-vacio">
                            <span>{{ $contenido->titulo }}</span>
                        </div>
                    @endif

                </div>

                {{-- Botón biblioteca --}}
                <div class="detalle-acciones">

                    <button
                        type="button"
                        class="boton-biblioteca-detalle"
                        title="Añadir a mi lista"
                        aria-label="Añadir {{ $contenido->titulo }} a mi lista"
                        data-abrir-biblioteca
                        data-id="{{ $contenido->id }}"
                        data-titulo="{{ $contenido->titulo }}"
                        data-tipo="{{ $contenido->tipo }}"
                        data-portada="{{ $contenido->poster ? asset($contenido->poster) : '' }}"
                        data-banner="{{ $contenido->banner ? asset($contenido->banner) : '' }}"
                        data-estado="{{ $contenido->estado_usuario ?? $contenido->estado ?? 'pendiente' }}"
                        data-puntuacion="{{ $contenido->puntuacion ?? '' }}"
                        data-fecha-inicio="{{ $contenido->fecha_inicio ?? '' }}"
                        data-fecha-fin="{{ $contenido->fecha_fin ?? '' }}"
                        data-notas="{{ $contenido->notas ?? '' }}"
                        data-favorito="{{ (int) ($contenido->favorito ?? 0) }}"
                        data-max-episodios="{{ $contenido->max_episodios ?? 0 }}"
                        data-episodios-vistos="{{ $contenido->episodios_vistos_usuario ?? 0 }}"
                    >
                        <span>＋</span>
                        Añadir a mi biblioteca
                    </button>

                </div>

                <br>

                {{-- Tipo --}}
                <div class="detalle-tipo">
                <span class="detalle-tipo-icono">
                    {{ $contenido->tipo === 'pelicula' ? '🎬' : '📺' }}
                </span>

                    {{ $contenido->tipo === 'pelicula' ? 'PELÍCULA' : 'SERIE' }}
                </div>

                {{-- Información básica --}}
                <div class="detalle-datos">

                    <h3>Información básica</h3>

                    <div class="dato-item">
                        <span class="dato-icono">📅</span>
                        <div>
                            <small>Año de estreno</small>
                            <strong>
                                {{ $contenido->fecha_estreno
                                    ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y')
                                    : 'Desconocido' }}
                            </strong>
                        </div>
                    </div>

                    @if ($contenido->tipo === 'pelicula')

                        @if ($contenido->duracion)
                            <div class="dato-item">
                                <span class="dato-icono">⏱</span>
                                <div>
                                    <small>Duración</small>
                                    <strong>{{ $contenido->duracion }} minutos</strong>
                                </div>
                            </div>
                        @endif

                    @else

                        <div class="dato-item">
                            <span class="dato-icono">📡</span>
                            <div>
                                <small>Estado de emisión</small>
                                <strong>{{ $contenido->estado_serie ?: 'Desconocido' }}</strong>
                            </div>
                        </div>

                        <div class="dato-item">
                            <span class="dato-icono">📚</span>
                            <div>
                                <small>Temporadas</small>
                                <strong>{{ $contenido->temporadas->count() }}</strong>
                            </div>
                        </div>

                        <div class="dato-item">
                            <span class="dato-icono">🎞</span>
                            <div>
                                <small>Episodios registrados</small>
                                <strong>
                                    {{ $contenido->temporadas->sum(fn($t) => $t->episodios->count()) }}
                                </strong>
                            </div>
                        </div>

                    @endif

                </div>

                {{-- Géneros --}}
                <div class="detalle-generos-sidebar">

                    <h3>Géneros</h3>

                    <div class="detalle-generos-lista">
                        @forelse ($contenido->generos as $genero)
                            <span class="genero-chip">
                            {{ $genero->nombre }}
                        </span>
                        @empty
                            <span class="genero-sin-datos">Sin géneros asignados</span>
                        @endforelse
                    </div>

                </div>

            </aside>

            {{-- COLUMNA DERECHA --}}
            <div class="detalle-main">

                {{-- Título y presentación --}}
                <section class="detalle-presentacion">

                    <div class="detalle-etiqueta">
                        {{ $contenido->tipo === 'pelicula' ? 'PELÍCULA' : 'SERIE DE TELEVISIÓN' }}
                    </div>

                    <h1>{{ $contenido->titulo }}</h1>

                    <div class="detalle-meta">

                        @if ($contenido->fecha_estreno)
                            <span>
                            📅 {{ \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y') }}
                        </span>
                        @endif

                        @if ($contenido->tipo === 'pelicula' && $contenido->duracion)
                            <span>⏱ {{ $contenido->duracion }} min</span>
                        @endif

                        @if ($contenido->tipo === 'serie' && $contenido->estado_serie)
                            <span>📡 {{ $contenido->estado_serie }}</span>
                        @endif

                    </div>

                </section>


                {{-- Sinopsis --}}
                <section class="detalle-bloque">

                    <div class="detalle-titulo-bloque">
                        <span class="detalle-linea"></span>
                        <h2>Sinopsis</h2>
                    </div>

                    <p class="detalle-sinopsis">
                        {{ $contenido->descripcion ?: 'No hay descripción disponible para este contenido.' }}
                    </p>

                </section>

                {{-- CONTENIDOS RELACIONADOS --}}
                @if ($relacionados->isNotEmpty())

                    <section class="relacionados-compactos">

                        <div class="relacionados-cabecera">
                            <h2>Relacionados</h2>
                            <span>{{ $relacionados->count() }}</span>
                        </div>

                        <div class="relacionados-lista">

                            @foreach ($relacionados as $relacionado)

                                @php
                                    $tiposRelacion = [
                                        'secuela' => 'Secuela',
                                        'precuela' => 'Precuela',
                                        'continuacion' => 'Continuación',
                                        'temporada_anterior' => 'Temporada anterior',
                                        'temporada_siguiente' => 'Temporada siguiente',
                                        'spin_off' => 'Spin-off',
                                        'remake' => 'Remake',
                                        'adaptacion' => 'Adaptación',
                                        'relacionado' => 'Relacionado',
                                    ];

                                    $tipoRelacion = $tiposRelacion[
                                        $relacionado->pivot->tipo_relacion
                                    ] ?? 'Relacionado';
                                @endphp

                                <a href="{{ route('contenidos.show', $relacionado) }}"
                                   class="relacionado-item">

                                    <div class="relacionado-poster">
                                        @if ($relacionado->poster)
                                            <img
                                                src="{{ asset($relacionado->poster) }}"
                                                alt="{{ $relacionado->titulo }}"
                                                loading="lazy">
                                        @else
                                            <span>🎬</span>
                                        @endif
                                    </div>

                                    <div class="relacionado-texto">
                                        <strong>{{ $relacionado->titulo }}</strong>
                                        <small>{{ $tipoRelacion }}</small>
                                    </div>

                                    <span class="relacionado-flecha">›</span>

                                </a>

                            @endforeach

                        </div>

                    </section>

                @endif

                {{-- Información de temporadas --}}
                @if ($contenido->tipo === 'serie')

                    <section class="detalle-bloque temporadas-seccion">

                        <div class="detalle-titulo-bloque">
                            <span class="detalle-linea"></span>
                            <h2>Temporadas y episodios</h2>
                            <span class="temporadas-contador">
                            {{ $contenido->temporadas->count() }}
                                {{ $contenido->temporadas->count() === 1 ? 'temporada' : 'temporadas' }}
                        </span>
                        </div>

                        @forelse ($contenido->temporadas as $temporada)

                            <div class="temporada-card">

                                <div class="temporada-cabecera">

                                    <div class="temporada-numero">
                                        {{ str_pad($temporada->numero, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="temporada-info">
                                        <h3>
                                            Temporada {{ $temporada->numero }}
                                        </h3>

                                        @if ($temporada->titulo)
                                            <p>{{ $temporada->titulo }}</p>
                                        @endif
                                    </div>

                                    <span class="temporada-episodios">
                                    {{ $temporada->episodios->count() }}
                                        {{ $temporada->episodios->count() === 1 ? 'episodio' : 'episodios' }}
                                </span>

                                </div>

                                @if ($temporada->episodios->isEmpty())

                                    <p class="temporada-vacia">
                                        No hay episodios registrados en esta temporada.
                                    </p>

                                @else

                                    <div class="episodios-lista">

                                        @foreach ($temporada->episodios as $episodio)

                                            <div class="episodio-item">

                                                <div class="episodio-numero">
                                                    {{ str_pad($episodio->numero, 2, '0', STR_PAD_LEFT) }}
                                                </div>

                                                <div class="episodio-info">
                                                    <strong>
                                                        {{ $episodio->titulo ?: 'Episodio ' . $episodio->numero }}
                                                    </strong>
                                                    <small>
                                                        Episodio {{ $episodio->numero }}
                                                    </small>
                                                </div>

                                                @if ($episodio->duracion)
                                                    <span class="episodio-duracion">
                                                    ⏱ {{ $episodio->duracion }} min
                                                </span>
                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        @empty

                            <div class="detalle-vacio">
                                <span>📺</span>
                                <h3>Sin temporadas disponibles</h3>
                                <p>Esta serie todavía no tiene temporadas registradas.</p>
                            </div>

                        @endforelse

                    </section>

                @endif

            </div>

        </article>


        {{-- RECOMENDACIONES AL FINAL --}}
        @if ($recomendaciones->isNotEmpty())

            <section class="recomendaciones-final">

                <div class="recomendaciones-cabecera">
                    <div>
                        <span>DESCUBRE MÁS</span>
                        <h2>También te puede interesar</h2>
                    </div>
                    <span class="recomendaciones-contador">
                {{ $recomendaciones->count() }}
            </span>
                </div>

                <div class="recomendaciones-grid">

                    @foreach ($recomendaciones as $recomendado)

                        <a href="{{ route('contenidos.show', $recomendado) }}"
                           class="recomendacion-card">

                            <div class="recomendacion-poster">

                                @if ($recomendado->poster)
                                    <img
                                        src="{{ asset($recomendado->poster) }}"
                                        alt="{{ $recomendado->titulo }}"
                                        loading="lazy">
                                @else
                                    <span>🎬</span>
                                @endif

                                <span class="recomendacion-tipo">
                            {{ $recomendado->tipo === 'pelicula' ? 'PELÍCULA' : 'SERIE' }}
                        </span>

                            </div>

                            <div class="recomendacion-info">
                                <strong>{{ $recomendado->titulo }}</strong>

                                <small>
                                    {{ $recomendado->fecha_estreno
                                        ? \Carbon\Carbon::parse($recomendado->fecha_estreno)->format('Y')
                                        : 'Año desconocido' }}
                                </small>
                            </div>

                        </a>

                    @endforeach

                </div>

            </section>

        @endif


    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contenidos-show.css') }}">
@endpush
