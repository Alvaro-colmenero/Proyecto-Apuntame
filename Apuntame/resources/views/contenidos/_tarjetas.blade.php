<!--
+-----------------------------------------------------------+
|¿Qué es esto?                                         _ ▄ x|
+-----------------------------------------------------------+
|Este es el modal encargado de asignalre ese estilo         |
|a las carteleras de las películas, se utilizan en múltiples|
|archivos, pero, sobretodo, en "index.blade.php".           |
+-----------------------------------------------------------+
-->
@include('biblioteca.modal')
<!--Si no hay ningún elemento en la variable lista. se evita la ejecución del código-->
@if ($lista->isEmpty())
    <p class="descripcion">No hay contenidos para mostrar.</p>
@else
    <!--Se le asigna el estilo de las tarjetas-->
    <link rel="stylesheet" href="{{ asset('css/tarjeta.css') }}">
    <!--
    Mediante un condicional ternario se determina si se tratan de tarjetas dentro
    de un carrusel o se tratan de las que se encuentran en el catálogo
    -->
    <div class="{{ !empty($modoCarrusel) && $modoCarrusel ? 'tarjetas-carrusel' : 'catalogo' }}">
        @foreach ($lista as $contenido)
            <article
                class="tarjeta tarjeta-con-boton"
                data-contenido-titulo="{{ $contenido->titulo }}"
                data-contenido-estado="{{ $contenido->estado_usuario ?? 'pendiente' }}"
                data-contenido-generos="{{ $contenido->generos ?? '' }}"
            >
                <!--Se le hace una llamada al modal de contenidos, pasándole la id de los contenidos en cuestión
                    todo claramente introducio dentro de una etiqueta <a> para que funcione como enlace que lo redirija
                    a la página principal del contenido en cuestión-->
                <a class="tarjeta-enlace" href="{{ route('contenidos.show', $contenido->id) }}">
                <!--
                En el caso en el que el contenido sea un poster, se muestra su imagen correspondiente, de lo contrario
                se muestra un poster vacio.
                -->
                @if ($contenido->poster)
                        <img class="poster" src="{{ asset($contenido->poster) }}" alt="Póster de {{ $contenido->titulo }}" loading="lazy">
                    @else
                        <div class="poster-vacio">
                            {{ $contenido->titulo }}
                        </div>
                    @endif

                    <!--Todo esto es la información que viene abajo de cada cartelera-->
                    <div class="tarjeta-info">
                        <h3>{{ $contenido->titulo }}</h3>
                        <!--
                        Al elemento que tenga fecha, se muestra su fecha correspondiente a través de un operador
                        ternario, de lo contrario, se muestra el texto 'Año desconocido'.
                        -->
                        <div class="meta">
                            {{ $contenido->fecha_estreno  ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y') : 'Año desconocido' }}
                            ·
                            {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
                        </div>

                        <!--
                        Muestra tan solo dos géneros a los que pertenezca el contenido en cuestión
                        -->
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

                <!--Este es el botón de añadir a mi lista-->
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
