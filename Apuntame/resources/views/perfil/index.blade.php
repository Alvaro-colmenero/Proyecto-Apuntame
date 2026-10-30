@extends('layouts.app')
@section('title', 'Mi perfil | Apuntame')
@include('biblioteca.modal')

@section('content')
    @php
        $usuarioPerfil = $usuarioPerfil ?? auth()->user();
        $nombrePerfil = $usuarioPerfil->nombre ?? 'Usuario';
        $contenidosPerfil = collect($contenidosPerfil ?? []);
        $actividadPerfil = collect($actividadPerfil ?? []);
    @endphp

    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

    <div class="perfil-pagina">

        {{-- PORTADA --}}
        <section class="perfil-portada">

            <div class="perfil-portada-fondo"
                 @if($usuarioPerfil?->banner)
                     style="background-image: url('{{ asset($usuarioPerfil->banner) }}')"
                @endif>
            </div>

            <div class="perfil-portada-degradado"></div>

            <div class="perfil-portada-etiqueta">
                <span>✦</span> MI ESPACIO PERSONAL
            </div>

            <div class="perfil-identidad">

                <div class="perfil-avatar-contenedor">
                    @if($usuarioPerfil?->avatar)
                        <img class="perfil-avatar" src="{{ asset($usuarioPerfil->avatar) }}" alt="Avatar de {{ $nombrePerfil }}">
                    @else
                        <div class="perfil-avatar perfil-avatar-placeholder">
                            {{ mb_strtoupper(mb_substr($nombrePerfil, 0, 1)) }}
                        </div>
                    @endif

                    <span class="perfil-avatar-estado"></span>
                </div>

                <div class="perfil-nombre">
                    <span class="perfil-etiqueta">MI PERFIL</span>
                    <h1>{{ $nombrePerfil }}</h1>
                    <p>Tu rincón personal para disfrutar del cine y las series.</p>
                </div>

                {{-- BOTÓN PARA ABRIR EL MODAL --}}
                <button class="perfil-accion" type="button" id="abrir-modal-perfil" aria-haspopup="dialog" aria-controls="modal-personalizacion">
                    <span>✎</span> Editar perfil
                </button>

                <a class="perfil-accion"
                   href="{{ route('contenidos.index') }}">
                    Explorar catálogo <span>→</span>
                </a>

            </div>
        </section>


        {{-- NAVEGACIÓN DEL PERFIL --}}
        <nav class="perfil-navegacion" aria-label="Secciones del perfil">
            <button type="button" class="perfil-tab activo"
                    data-seccion="inicio" aria-selected="true">
                <span>⌂</span> Inicio
            </button>

            <button type="button" class="perfil-tab"
                    data-seccion="peliculas" aria-selected="false">
                <span>▣</span> Películas
            </button>

            <button type="button" class="perfil-tab"
                    data-seccion="series" aria-selected="false">
                <span>▤</span> Series
            </button>

            <button type="button" class="perfil-tab"
                    data-seccion="estadisticas" aria-selected="false">
                <span>▥</span> Estadísticas
            </button>

            <button type="button" class="perfil-tab"
                    data-seccion="social" aria-selected="false">
                <span>♧</span> Social
            </button>
        </nav>


        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="perfil-mensaje perfil-mensaje-ok">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="perfil-mensaje perfil-mensaje-error">
                <strong>No se han podido guardar los cambios:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="perfil-columnas">

            {{-- COLUMNA PRINCIPAL --}}

            {{-- COLUMNA PRINCIPAL: CONTENIDO INTERCAMBIABLE --}}
            <div class="perfil-principal">

                {{-- INICIO --}}
                <section class="perfil-vista" data-vista="inicio">

                    <section class="perfil-panel">
                        <div class="perfil-panel-titulo">
                            <div>
                                <span class="perfil-mini-etiqueta">TU COLECCIÓN</span>
                                <h2>Mi biblioteca</h2>
                                <p>Tus contenidos favoritos, en un mismo lugar.</p>
                            </div>
                            <span class="perfil-panel-icono">▤</span>
                        </div>

                        @if($contenidosPerfil->isNotEmpty())
                            <section class="seccion">
                                <div class="titulo-seccion">
                                    <h2>MI BIBLIOTECA</h2>
                                    <span>{{ $contenidosPerfil->count() }} contenidos</span>
                                </div>
                                @include('contenidos._tarjetas', [ 'lista' => $contenidosPerfil ])
                            </section>
                        @else
                            <div class="perfil-vacio">
                                <p>Todavía no has agregado películas o series a tu biblioteca.</p>
                                <a href="{{ route('contenidos.index') }}" class="boton">
                                    Explorar catálogo
                                </a>
                            </div>
                        @endif
                    </section>

                </section>


                {{-- PELÍCULAS --}}
                <section class="perfil-vista" data-vista="peliculas" hidden>
                    <section class="perfil-panel">

                        <div class="perfil-panel-titulo">
                            <div>
                                <span class="perfil-mini-etiqueta">TU COLECCIÓN</span>
                                <h2>Mis películas</h2>
                                <p>Organiza tu progreso personal.</p>
                            </div>

                        </div>

                        <div class="perfil-biblioteca-layout">
                            @include('biblioteca.filtros', [ 'tipo' => 'pelicula', 'contenidos' => $peliculasPerfil ])
                            <div class="perfil-biblioteca-resultados">
                                @if($peliculasPerfil->isNotEmpty())
                                    @foreach($estadosBiblioteca as $estado => $tituloEstado)
                                        @php
                                            $listaEstado = $peliculasPerfil->get($estado, collect());
                                        @endphp
                                        @if($listaEstado->isNotEmpty())
                                            <section class="perfil-fila-contenidos" data-grupo-estado="{{ $estado }}">
                                                <div class="titulo-seccion">
                                                    <h2>{{ $tituloEstado }}</h2>
                                                    <span>{{ $listaEstado->count() }} películas</span>
                                                </div>
                                                @include('contenidos._tarjetas', [ 'lista' => $listaEstado ])
                                            </section>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="perfil-vacio">
                                        <p>Todavía no tienes películas en tu biblioteca.</p>
                                        <a href="{{ route('contenidos.index') }}" class="boton">
                                            Explorar películas
                                        </a>
                                    </div>
                                @endif
                                <p class="perfil-filtro-sin-resultados" hidden>
                                    No se encontraron películas con esos filtros.
                                </p>

                            </div>
                        </div>
                    </section>
                </section>


                {{-- SERIES --}}
                <section class="perfil-vista" data-vista="series" hidden>
                    <section class="perfil-panel">

                        <div class="perfil-panel-titulo">
                            <div>
                                <span class="perfil-mini-etiqueta">TU COLECCIÓN</span>
                                <h2>Mis series</h2>
                                <p>Sigue tus series.</p>
                            </div>
                        </div>

                        <div class="perfil-biblioteca-layout">
                            @include('biblioteca.filtros', [ 'tipo' => 'serie', 'contenidos' => $seriesPerfil ])
                            <div class="perfil-biblioteca-resultados">
                                @if($seriesPerfil->isNotEmpty())
                                    @foreach($estadosBiblioteca as $estado => $tituloEstado)
                                        @php
                                            $listaEstado = $seriesPerfil->get($estado, collect());
                                        @endphp
                                        @if($listaEstado->isNotEmpty())
                                            <section class="perfil-fila-contenidos" data-grupo-estado="{{ $estado }}">
                                                <div class="titulo-seccion">
                                                    <h2>{{ $tituloEstado }}</h2>
                                                    <span>{{ $listaEstado->count() }} series</span>
                                                </div>
                                                @include('contenidos._tarjetas', [ 'lista' => $listaEstado ])
                                            </section>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="perfil-vacio">
                                        <p>Todavía no tienes series en tu biblioteca.</p>
                                        <a href="{{ route('contenidos.index') }}" class="boton">
                                            Explorar series
                                        </a>
                                    </div>
                                @endif
                                <p class="perfil-filtro-sin-resultados" hidden>
                                    No se encontraron series con esos filtros.
                                </p>
                            </div>
                        </div>
                    </section>
                </section>


                {{-- SOCIAL --}}
                <section class="perfil-vista" data-vista="social" hidden>

                    <section class="perfil-panel">
                        <div class="perfil-panel-titulo">
                            <div>
                                <span class="perfil-mini-etiqueta">COMUNIDAD</span>
                                <h2>Mi espacio social</h2>
                                <p>Muy pronto podrás conectar con otros amantes del cine y las series.</p>
                            </div>
                            <span class="perfil-panel-icono">♧</span>
                        </div>

                        <div class="perfil-vacio">
                            <p>Tu espacio social estará disponible próximamente.</p>
                        </div>
                    </section>

                </section>

            </div>


            {{-- COLUMNA LATERAL --}}
            <aside class="perfil-lateral">

                <section class="perfil-panel perfil-cuenta" id="perfil-cuenta">
                    <span class="perfil-mini-etiqueta">TU CUENTA</span>
                    <h2>Información personal</h2>

                    <div class="perfil-dato">
                        <span>Nombre</span>
                        <strong>{{ $nombrePerfil }}</strong>
                    </div>

                    <div class="perfil-dato">
                        <span>Correo electrónico</span>
                        <strong>{{ $usuarioPerfil->email ?? 'No disponible' }}</strong>
                    </div>

                    <div class="perfil-dato">
                        <span>Miembro desde</span>
                        <strong>
                            {{ $usuarioPerfil?->created_at ? $usuarioPerfil->created_at->format('d/m/Y') : '—' }}
                        </strong>
                    </div>
                </section>

                <section class="perfil-panel perfil-favoritos" id="perfil-actividad">
                    <span class="perfil-mini-etiqueta">TU SELECCIÓN PERSONAL</span>
                    <h2>Mis favoritos</h2>
                    @if(isset($favoritosPerfil) && $favoritosPerfil->isNotEmpty())
                        <div class="perfil-favoritos-lista">
                            @foreach($favoritosPerfil as $favorito)
                                <div class="perfil-favorito-item">

                                    <img src="{{ $favorito->poster }}" alt="{{ $favorito->titulo }}" class="perfil-favorito-poster">

                                    <div class="perfil-favorito-info">
                                        <strong>{{ $favorito->titulo }}</strong>
                                        <small>
                                            {{ $favorito->tipo === 'pelicula' ? 'Película' : 'Serie' }}
                                            @if(!empty($favorito->fecha_estreno))
                                                · {{ substr($favorito->fecha_estreno, 0, 4) }}
                                            @endif
                                        </small>
                                    </div>

                                    <span class="perfil-favorito-corazon">♥</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="perfil-actividad-vacia">
                            <span>♥</span>
                            <p>Todavía no tienes favoritos. Marca tus películas y series preferidas con el corazón.</p>
                        </div>
                    @endif
                </section>

            </aside>
        </div>
    </div>

    {{-- MODAL DE PERSONALIZACIÓN DEL PERFIL --}}
    <div class="perfil-modal" id="modal-personalizacion" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-perfil" aria-describedby="descripcion-modal-perfil" @if(!$errors->any()) hidden @endif>
        <div class="perfil-modal-fondo" data-cerrar-modal></div>
        <div class="perfil-modal-contenido" tabindex="-1">

            <div class="perfil-modal-cabecera">
                <div>
                    <span class="perfil-mini-etiqueta">PERSONALIZACIÓN</span>
                    <h2 id="titulo-modal-perfil">Tu perfil, a tu estilo</h2>
                    <p id="descripcion-modal-perfil">
                        Cambia tu foto y el fondo de tu portada.
                    </p>
                </div>

                <button type="button" class="perfil-modal-cerrar" aria-label="Cerrar ventana de edición" data-cerrar-modal>
                    &times;
                </button>
            </div>

            <div class="perfil-modal-cuerpo">

                <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data" class="perfil-form">
                    @csrf
                    @method('PUT')

                    {{-- AVATAR --}}
                    <div class="perfil-imagen-campo">
                        <div class="perfil-preview-avatar">

                            @if($usuarioPerfil?->avatar)
                                <img id="preview-avatar" src="{{ asset($usuarioPerfil->avatar) }}" alt="Vista previa del avatar">
                            @else
                                <div id="preview-avatar-placeholder">
                                    {{ mb_strtoupper(mb_substr($nombrePerfil, 0, 1)) }}
                                </div>

                                <img id="preview-avatar" src="" alt="Vista previa del avatar" hidden>
                            @endif

                        </div>

                        <div class="perfil-imagen-descripcion">
                            <label for="avatar">Foto de perfil</label>
                            <p>Tu imagen personal en Apuntame.</p>
                            <label class="perfil-boton-archivo" for="avatar">Elegir imagen</label>
                            <input id="avatar" class="perfil-input-archivo" type="file" name="avatar" accept="image/jpeg,image/png,image/webp">
                            <small>JPG, PNG o WEBP. Máximo 2 MB.</small>
                        </div>
                    </div>

                    {{-- BANNER --}}
                    <div class="perfil-banner-campo">

                        <div class="perfil-preview-banner" id="preview-banner" @if($usuarioPerfil?->banner)style="background-image:url('{{ asset($usuarioPerfil->banner) }}')"@endif>
                            <span>Vista previa de tu portada</span>
                        </div>

                        <label for="banner">Imagen de portada</label>
                        <p>Elige una imagen panorámica para personalizar tu perfil.</p>
                        <label class="perfil-boton-archivo" for="banner">Elegir banner</label>
                        <input id="banner" class="perfil-input-archivo" type="file" name="banner" accept="image/jpeg,image/png,image/webp">
                        <small>JPG, PNG o WEBP. Máximo 5 MB.</small>
                    </div>

                    {{-- BOTONES DEL MODAL --}}
                    <div class="perfil-form-acciones">
                        <button class="perfil-cancelar" type="button" data-cerrar-modal>Cancelar</button>
                        <button class="perfil-guardar" type="submit">Guardar cambios →</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modal = document.getElementById('modal-personalizacion');
            const botonAbrir = document.getElementById('abrir-modal-perfil');
            const botonCerrar = modal.querySelector('.perfil-modal-cerrar');
            const contenidoModal = modal.querySelector('.perfil-modal-contenido');
            const controlesCerrar = modal.querySelectorAll('[data-cerrar-modal]');

            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('preview-avatar');
            const avatarPlaceholder = document.getElementById('preview-avatar-placeholder');

            const bannerInput = document.getElementById('banner');
            const bannerPreview = document.getElementById('preview-banner');

            let elementoAnterior = null;

            // Abrir modal
            function abrirModal() {
                if (!modal.hidden) {
                    return;
                }

                elementoAnterior = document.activeElement;
                modal.hidden = false;
                document.body.style.overflow = 'hidden';
                botonCerrar.focus();
            }

            // Cerrar modal
            function cerrarModal() {
                if (modal.hidden) {
                    return;
                }

                modal.hidden = true;
                document.body.style.overflow = '';

                if (elementoAnterior) {
                    elementoAnterior.focus();
                }
            }

            botonAbrir.addEventListener('click', abrirModal);

            controlesCerrar.forEach(function (control) {
                control.addEventListener('click', cerrarModal);
            });

            // Cerrar al pulsar Escape
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.hidden) {
                    cerrarModal();
                }
            });

            // Mantener el foco dentro del modal mientras esté abierto
            modal.addEventListener('keydown', function (event) {
                if (event.key !== 'Tab' || modal.hidden) {
                    return;
                }

                const elementos = modal.querySelectorAll(
                    'button:not([disabled]), input:not([disabled]), ' +
                    'a[href], [tabindex]:not([tabindex="-1"])'
                );

                const visibles = Array.from(elementos).filter(function (elemento) {
                    return elemento.getClientRects().length > 0;
                });

                if (visibles.length === 0) {
                    event.preventDefault();
                    contenidoModal.focus();
                    return;
                }

                const primero = visibles[0];
                const ultimo = visibles[visibles.length - 1];

                if (event.shiftKey && document.activeElement === primero) {
                    event.preventDefault();
                    ultimo.focus();
                } else if (
                    !event.shiftKey &&
                    document.activeElement === ultimo
                ) {
                    event.preventDefault();
                    primero.focus();
                }
            });

            // Vista previa de imágenes seleccionadas
            function previewImage(input, callback) {
                input.addEventListener('change', function () {
                    const file = this.files && this.files[0];

                    if (!file || !file.type.startsWith('image/')) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (event) {callback(event.target.result);};

                    reader.readAsDataURL(file);
                });
            }

            previewImage(avatarInput, function (src) {
                avatarPreview.src = src;
                avatarPreview.hidden = false;
                if (avatarPlaceholder) {avatarPlaceholder.hidden = true;}
            });

            previewImage(bannerInput, function (src) {bannerPreview.style.backgroundImage = 'url("' + src + '")';});

            // Si Laravel devuelve errores de validación,
            // el modal permanece abierto automáticamente.
            @if($errors->any())
            abrirModal();
            @endif

            // Navegación entre las secciones del perfil
            const pestañasPerfil = document.querySelectorAll('.perfil-tab');
            const vistasPerfil = document.querySelectorAll('.perfil-vista');

            function mostrarSeccionPerfil(seccion) {
                const vistaDestino = Array.from(vistasPerfil).find(function (vista) {
                    return vista.dataset.vista === seccion;
                });

                if (!vistaDestino) {return;}

                const esInicio = seccion === 'inicio';

                // Cambiar contenido visible
                vistasPerfil.forEach(function (vista) {
                    vista.hidden = vista !== vistaDestino;
                });

                // Actualizar pestañas
                pestañasPerfil.forEach(function (pestana) {
                    const activa = pestana.dataset.seccion === seccion;

                    pestana.classList.toggle('activo', activa);
                    pestana.setAttribute('aria-selected', String(activa));
                });

                // Obtener bloques laterales
                const columnasPerfil = document.querySelector('.perfil-columnas');
                const bloqueCuenta = document.getElementById('perfil-cuenta');
                const bloqueActividad = document.getElementById('perfil-actividad');

                // Mostrar únicamente en Inicio
                bloqueCuenta.hidden = !esInicio;
                bloqueActividad.hidden = !esInicio;

                // Adaptar el ancho del contenido
                columnasPerfil.classList.toggle('perfil-sin-cuenta', !esInicio);
            }

            pestañasPerfil.forEach(function (pestana) {
                pestana.addEventListener('click', function () {
                    mostrarSeccionPerfil(pestana.dataset.seccion);
                });
            });

            // Mostrar Inicio al cargar la página
            mostrarSeccionPerfil('inicio');

        });

        document.querySelectorAll('[data-filtros-biblioteca]').forEach(filtros => {

            const tipo = filtros.dataset.filtrosBiblioteca;
            const vista = document.querySelector(`.perfil-vista[data-vista="${tipo === 'pelicula' ? 'peliculas' : 'series'}"]`);

            if (!vista) return;
            const buscador = filtros.querySelector('[data-filtro-busqueda]');
            const estados = filtros.querySelectorAll('[data-filtro-estado]');
            const generos = filtros.querySelectorAll('[data-filtro-genero]');
            const limpiar = filtros.querySelector('[data-limpiar-filtros]');
            const tarjetas = vista.querySelectorAll('.tarjeta');
            const mensajeVacio = vista.querySelector('.perfil-filtro-sin-resultados');

            function aplicarFiltros() {

                const texto = buscador.value.trim().toLocaleLowerCase('es');
                const estadoSeleccionado = filtros.querySelector('[data-filtro-estado]:checked').value;
                const generosSeleccionados = Array.from(generos).filter(g => g.checked).map(g => g.value.toLocaleLowerCase('es'));

                let resultados = 0;

                tarjetas.forEach(tarjeta => {

                    const titulo = (tarjeta.dataset.contenidoTitulo || '').toLocaleLowerCase('es');
                    const estado = tarjeta.dataset.contenidoEstado;

                    const listaGeneros = (tarjeta.dataset.contenidoGeneros || '')
                        .split('|')
                        .map(g => g.trim().toLocaleLowerCase('es'));

                    const coincideTexto = titulo.includes(texto);
                    const coincideEstado = estadoSeleccionado === 'todos' || estado === estadoSeleccionado;
                    const coincideGenero = generosSeleccionados.length === 0 || generosSeleccionados.every(g => listaGeneros.includes(g));
                    const mostrar = coincideTexto && coincideEstado && coincideGenero;

                    tarjeta.hidden = !mostrar;
                    if (mostrar) resultados++;

                });

                vista.querySelectorAll('.perfil-fila-contenidos').forEach(grupo => {

                    const tarjetasVisibles = grupo.querySelectorAll('.tarjeta:not([hidden])');
                    grupo.hidden = tarjetasVisibles.length === 0;

                });

                mensajeVacio.hidden = resultados > 0;
            }

            buscador.addEventListener('input', aplicarFiltros);
            estados.forEach(input => {input.addEventListener('change', aplicarFiltros);});
            generos.forEach(input => {input.addEventListener('change', aplicarFiltros);});

            limpiar.addEventListener('click', () => {

                buscador.value = '';
                estados.forEach(input => {input.checked = input.value === 'todos';});
                generos.forEach(input => {input.checked = false;});

                aplicarFiltros();
            });

        });


    </script>
@endsection
