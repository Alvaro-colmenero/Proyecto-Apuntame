@php
    $todosLosContenidos = $contenidos->flatten(1);
    $generosDisponibles = $todosLosContenidos
        ->flatMap(function ($contenido) {return explode('|', $contenido->generos ?? '');})
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

<aside class="perfil-filtros"
       data-filtros-biblioteca="{{ $tipo }}">

    <div class="perfil-filtros-cabecera">
        <span class="perfil-mini-etiqueta">EXPLORAR</span>
        <h3>Filtrar colección</h3>
    </div>

    <div class="perfil-filtro-buscador">
        <label for="buscar-{{ $tipo }}">Buscar contenido</label>
        <input type="search" id="buscar-{{ $tipo }}" placeholder="Buscar por título..." data-filtro-busqueda>
    </div>

    <div class="perfil-filtro-grupo">
        <h4>Estado</h4>

        <label>
            <input type="radio" name="estado-{{ $tipo }}" value="todos" checked data-filtro-estado>
            Todos
        </label>

        @foreach([
            'pendiente' => 'Mi lista',
            'viendo' => 'En curso',
            'vista' => 'Vistas',
            'pausada' => 'En pausa',
            'abandonada' => 'Abandonadas'
        ] as $estado => $nombre)

            <label>
                <input type="radio" name="estado-{{ $tipo }}" value="{{ $estado }}" data-filtro-estado>
                {{ $nombre }}
            </label>

        @endforeach
    </div>

    <div class="perfil-filtro-grupo">
        <h4>Géneros</h4>

        @forelse($generosDisponibles as $genero)
            <label>
                <input type="checkbox" value="{{ $genero }}" data-filtro-genero>
                {{ $genero }}
            </label>
        @empty
            <p>No hay géneros disponibles.</p>
        @endforelse
    </div>

    <button type="button" class="perfil-filtro-limpiar" data-limpiar-filtros>
        Limpiar filtros
    </button>

</aside>
