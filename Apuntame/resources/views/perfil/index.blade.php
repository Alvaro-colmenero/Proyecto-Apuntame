@extends('layouts.app')
@section('title', 'Mi perfil | Apuntame')


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
            <div class="perfil-principal">

                {{-- BIBLIOTECA --}}
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

            </div>

            {{-- COLUMNA LATERAL --}}
            <aside class="perfil-lateral">

                <section class="perfil-panel perfil-cuenta">
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

                <section class="perfil-panel perfil-actividad">
                    <span class="perfil-mini-etiqueta">ÚLTIMOS MOVIMIENTOS</span>
                    <h2>Actividad reciente</h2>

                    @if($actividadPerfil->isNotEmpty())
                        @foreach($actividadPerfil as $actividad)
                            <div class="perfil-actividad-item">
                                <span class="perfil-actividad-punto"></span>
                                <div>
                                    <strong>
                                        {{ $actividad->descripcion ?? $actividad->titulo ?? 'Actividad' }}
                                    </strong>

                                    @if(!empty($actividad->created_at))
                                        <small>
                                            {{ \Carbon\Carbon::parse($actividad->created_at)->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="perfil-actividad-vacia">
                            <span>◷</span>
                            <p>Aquí aparecerá tu actividad cuando empieces a utilizar tu biblioteca.</p>
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

        });




    </script>
@endsection
