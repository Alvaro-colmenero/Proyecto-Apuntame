
@if ($lista->isEmpty())
    <p class="descripcion">No hay contenidos para mostrar.</p>
@else
    <div class="catalogo">
        @foreach ($lista as $contenido)
            <a class="tarjeta"
               href="{{ route('contenidos.show', $contenido) }}">

                @if ($contenido->poster)
                    <img
                        class="poster"
                        src="{{ asset($contenido->poster) }}"
                        alt="Póster de {{ $contenido->titulo }}"
                        loading="lazy"
                    >
                @else
                    <div class="poster-vacio">
                        {{ $contenido->titulo }}
                    </div>
                @endif

                <div class="tarjeta-info">
                    <h3>{{ $contenido->titulo }}</h3>

                    <div class="meta">
                        {{ $contenido->fecha_estreno ? \Carbon\Carbon::parse($contenido->fecha_estreno)->format('Y') : 'Año desconocido' }}
                        ·
                        {{ $contenido->tipo === 'pelicula' ? 'Película' : 'Serie' }}
                    </div>

                    @foreach ($contenido->generos->take(3) as $genero)
                        <span class="etiqueta">{{ $genero->nombre }}</span>
                    @endforeach
                </div>
            </a>
        @endforeach
    </div>
@endif
