<!--
+-----------------------------------------------------------------------------+
|¿Qué es esto?                                                           _ ▄ x|
+-----------------------------------------------------------------------------+
|Esta es la página de cada película, por ahora tan solo se muetra información |
|superficial de esta, se tiene pensado implementar más datos y incluso una    |
|sección de comunidad y que se muestre el catálogo de recomendaciones.        |
+-----------------------------------------------------------------------------+
-->
@extends('layouts.app')
@section('title', $contenido->titulo . ' | MiCineSeries')
@section('content')
@include('biblioteca.modal')

    <!--
    En la parte de arriba se crea un botón para que se de al usuario la opción para que regrese
    a la página de donde biene.
    -->
    <p>
        <a class="boton boton-secundario" href="{{ url()->previous() }}">
            ← Volver
        </a>
    </p>

    <!--
    Todo esto es la información que se encuentra en la parte superior de la página
    incluyendo, el banner de la película, su portada, el título de esta y su información
    -->
    <article class="detalle">
        <div class="banner" @if ($contenido->banner || $contenido->poster) style="background-image: url('{{ asset($contenido->banner ?: $contenido->poster) }}')" @endif>
        </div>

        <div class="detalle-contenido">
            @if ($contenido->poster)
                <img class="detalle-poster" src="{{ asset($contenido->poster) }}" alt="Póster de {{ $contenido->titulo }}">
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


                <button type="button"
                        class="boton"
                        data-abrir-biblioteca
                        data-id="{{ $contenido->id }}"
                        data-titulo="{{ $contenido->titulo }}"
                        data-tipo="{{ $contenido->tipo }}"
                        data-portada="{{ $contenido->poster ? asset($contenido->poster) : '' }}"
                        data-banner="{{ $contenido->banner ? asset($contenido->banner) : '' }}"
                        title="Añadir a mi lista"
                        aria-label="Añadir {{ $contenido->titulo }} a mi lista"
                        data-estado="{{ $contenido->estado_usuario ?? $contenido->estado ?? 'pendiente' }}"
                        data-puntuacion="{{ $contenido->puntuacion ?? '' }}"
                        data-fecha-inicio="{{ $contenido->fecha_inicio ?? '' }}"
                        data-fecha-fin="{{ $contenido->fecha_fin ?? '' }}"
                        data-notas="{{ $contenido->notas ?? '' }}"
                        data-favorito="{{ (int) ($contenido->favorito ?? 0) }}"
                >
                    + Añadir a mi lista
                </button>


                <p class="descripcion">
                    {{ $contenido->fecha_estreno ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y') : 'Año desconocido' }}
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

    <!--
    En el caso en el que se detecte que es una serie, se mostrará una lista por cada temporada que esta tenga
    y los episodios que esta tiene.
    -->
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
