@include('biblioteca.modal')

@if ($lista->isEmpty())
    <p class="descripcion">No hay contenidos para mostrar.</p>
@else
    <link rel="stylesheet" href="{{ asset('css/tarjeta.css') }}">
    <div class="{{ !empty($modoCarrusel) && $modoCarrusel ? 'tarjetas-carrusel' : 'catalogo' }}">
        @foreach ($lista as $contenido)

            <article
                class="tarjeta tarjeta-con-boton"
                data-contenido-titulo="{{ $contenido->titulo }}"
                data-contenido-estado="{{ $contenido->estado_usuario ?? 'pendiente' }}"
                data-contenido-generos="{{ $contenido->generos ?? '' }}"
            >

                <a class="tarjeta-enlace" href="{{ route('contenidos.show', $contenido->id) }}">

                @if ($contenido->poster)
                        <img class="poster" src="{{ asset($contenido->poster) }}" alt="Póster de {{ $contenido->titulo }}" loading="lazy">
                    @else
                        <div class="poster-vacio">
                            {{ $contenido->titulo }}
                        </div>
                    @endif

                    <div class="tarjeta-info">
                        <h3>{{ $contenido->titulo }}</h3>

                        <div class="meta">
                            {{ $contenido->fecha_estreno  ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y') : 'Año desconocido' }}
                            ·
                            {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
                        </div>


                        <div class="tarjeta-generos">
                            @if(isset($contenido->generos) && $contenido->generos)
                                @foreach(collect($contenido->generos)->take(2) as $genero)
                                    <span class="etiqueta">
                                        {{ is_object($genero) ? $genero->nombre : $genero }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </a>

                {{-- Botón para abrir el modal sin entrar en la ficha --}}
                <button
                    type="button"
                    class="boton-lista-mini"
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
                >
                    +
                </button>
            </article>
        @endforeach
    </div>
@endif
