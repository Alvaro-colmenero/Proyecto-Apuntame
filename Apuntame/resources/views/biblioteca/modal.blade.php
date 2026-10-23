
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">

<div id="modalBiblioteca" class="modal-biblioteca" hidden>
    <div class="modal-biblioteca-fondo" data-cerrar-modal></div>

    <div
        class="modal-biblioteca-contenido"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalBibliotecaTitulo"
        tabindex="-1"
    >
        <button
            type="button"
            class="modal-biblioteca-cerrar"
            data-cerrar-modal
            aria-label="Cerrar modal"
        >
            &times;
        </button>

        {{-- BANNER --}}
        <div id="bibliotecaBanner" class="biblioteca-banner"></div>

        {{-- CABECERA: PÓSTER, FAVORITO E INFORMACIÓN --}}
        <div class="biblioteca-cabecera">
            <div class="biblioteca-portada-contenedor">
                <img
                    id="bibliotecaPortada"
                    class="biblioteca-portada"
                    src=""
                    alt=""
                    hidden
                >

                <div
                    id="bibliotecaPortadaVacia"
                    class="biblioteca-portada-vacia"
                    hidden
                >
                    Sin portada
                </div>

                <button
                    type="button"
                    id="bibliotecaBotonFavorito"
                    class="biblioteca-boton-favorito"
                    aria-label="Añadir a favoritos"
                    aria-pressed="false"
                    title="Añadir a favoritos"
                >
                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                        class="biblioteca-icono-corazon"
                    >
                        <path
                            d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"
                        />
                    </svg>
                </button>
            </div>

            <div class="biblioteca-cabecera-texto">
                <span id="bibliotecaTipo" class="etiqueta"></span>
                <h2 id="modalBibliotecaTitulo">Mi biblioteca</h2>
                <p id="modalBibliotecaNombre" class="descripcion"></p>

                <span
                    id="bibliotecaEstadoFavorito"
                    class="biblioteca-texto-favorito"
                    hidden
                >
                    ♥ En favoritos
                </span>
            </div>
        </div>

        {{-- FORMULARIO --}}
        <form
            id="formularioBiblioteca"
            method="POST"
            action="{{ route('biblioteca.guardar') }}"
        >
            @csrf

            <input
                type="hidden"
                name="contenido_id"
                id="bibliotecaContenidoId"
            >

            <input
                type="hidden"
                name="favorito"
                id="bibliotecaFavorito"
                value="0"
            >

            <div class="biblioteca-form-grid">

                {{-- ESTADO --}}
                <div class="biblioteca-campo">
                    <label for="bibliotecaEstado">Estado</label>
                    <select name="estado" id="bibliotecaEstado" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="viendo" data-solo-serie>Viendo</option>
                        <option value="vista">Vista</option>
                        <option value="pausada">Pausada</option>
                        <option value="abandonada">Abandonada</option>
                    </select>
                </div>

                {{-- PUNTUACIÓN --}}
                <div class="biblioteca-campo">
                    <label for="bibliotecaPuntuacion">Mi puntuación</label>
                    <select name="puntuacion" id="bibliotecaPuntuacion">
                        <option value="">Sin puntuar</option>
                        @for($nota = 0; $nota <= 10; $nota += 0.5)
                            <option value="{{ number_format($nota, 1, '.', '') }}">
                                {{ number_format($nota, 1, ',', '') }} / 10
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- FECHA DE INICIO --}}
                <div class="biblioteca-campo">
                    <label for="bibliotecaFechaInicio">Fecha de inicio</label>
                    <input
                        type="date"
                        name="fecha_inicio"
                        id="bibliotecaFechaInicio"
                    >
                </div>

                {{-- FECHA DE FIN --}}
                <div class="biblioteca-campo">
                    <label for="bibliotecaFechaFin">Fecha de finalización</label>
                    <input
                        type="date"
                        name="fecha_fin"
                        id="bibliotecaFechaFin"
                    >
                </div>

            </div>

            {{-- NOTAS --}}
            <div class="biblioteca-campo biblioteca-campo-notas">
                <label for="bibliotecaNotas">Mis notas personales</label>
                <textarea
                    name="notas"
                    id="bibliotecaNotas"
                    rows="4"
                    maxlength="5000"
                    placeholder="¿Qué te parece? ¿Por qué quieres verla? ¿En qué episodio te quedaste?"
                ></textarea>

                <div class="biblioteca-contador">
                    <span id="bibliotecaCaracteres">0</span>/5000 caracteres
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="modal-biblioteca-acciones">
                <button
                    type="button"
                    class="boton boton-secundario"
                    data-cerrar-modal
                >
                    Cancelar
                </button>

                <button type="submit" class="boton">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        function inicializarModalBiblioteca() {
            const modal = document.getElementById('modalBiblioteca');

            if (!modal || modal.dataset.inicializado) return;
            modal.dataset.inicializado = 'true';

            const idInput = document.getElementById('bibliotecaContenidoId');
            const titulo = document.getElementById('modalBibliotecaTitulo');
            const nombre = document.getElementById('modalBibliotecaNombre');
            const tipoTexto = document.getElementById('bibliotecaTipo');
            const estado = document.getElementById('bibliotecaEstado');
            const puntuacion = document.getElementById('bibliotecaPuntuacion');
            const fechaInicio = document.getElementById('bibliotecaFechaInicio');
            const fechaFin = document.getElementById('bibliotecaFechaFin');
            const notas = document.getElementById('bibliotecaNotas');
            const contador = document.getElementById('bibliotecaCaracteres');
            const banner = document.getElementById('bibliotecaBanner');
            const portada = document.getElementById('bibliotecaPortada');
            const portadaVacia = document.getElementById('bibliotecaPortadaVacia');
            const botonFavorito = document.getElementById('bibliotecaBotonFavorito');
            const favoritoInput = document.getElementById('bibliotecaFavorito');
            const textoFavorito = document.getElementById('bibliotecaEstadoFavorito');
            const opcionViendo = estado.querySelector('[data-solo-serie]');

            function actualizarFavorito(esFavorito) {
                favoritoInput.value = esFavorito ? '1' : '0';
                botonFavorito.classList.toggle('es-favorito', esFavorito);
                botonFavorito.setAttribute('aria-pressed', String(esFavorito));
                botonFavorito.setAttribute(
                    'aria-label',
                    esFavorito ? 'Quitar de favoritos' : 'Añadir a favoritos'
                );
                botonFavorito.title = esFavorito
                    ? 'Quitar de favoritos'
                    : 'Añadir a favoritos';

                textoFavorito.hidden = !esFavorito;
            }

            function abrirModal(datos) {
                idInput.value = datos.id || '';
                titulo.textContent = datos.titulo || 'Mi biblioteca';
                nombre.textContent = datos.titulo || '';

                const esSerie = datos.tipo === 'serie';
                tipoTexto.textContent = esSerie ? 'Serie' : 'Película';

                opcionViendo.hidden = !esSerie;
                opcionViendo.disabled = !esSerie;

                const estadoSolicitado = datos.estado || 'pendiente';
                estado.value = (!esSerie && estadoSolicitado === 'viendo')
                    ? 'pendiente'
                    : estadoSolicitado;

                puntuacion.value = datos.puntuacion || '';
                fechaInicio.value = datos.fechaInicio || '';
                fechaFin.value = datos.fechaFin || '';
                notas.value = datos.notas || '';
                contador.textContent = notas.value.length;

                banner.style.backgroundImage = datos.banner
                    ? `url("${datos.banner}")`
                    : 'none';

                if (datos.portada) {
                    portada.src = datos.portada;
                    portada.alt = 'Portada de ' + (datos.titulo || '');
                    portada.hidden = false;
                    portadaVacia.hidden = true;
                } else {
                    portada.removeAttribute('src');
                    portada.alt = '';
                    portada.hidden = true;
                    portadaVacia.hidden = false;
                }

                actualizarFavorito(
                    datos.favorito === '1' ||
                    datos.favorito === 'true'
                );

                modal.hidden = false;
                document.body.style.overflow = 'hidden';
            }

            function cerrarModal() {
                modal.hidden = true;
                document.body.style.overflow = '';
            }

            document.addEventListener('click', function (event) {
                const objetivo = event.target instanceof Element
                    ? event.target
                    : event.target.parentElement;

                if (!objetivo) return;

                const boton = objetivo.closest('[data-abrir-biblioteca]');

                if (boton) {
                    event.preventDefault();

                    abrirModal({
                        id: boton.dataset.id,
                        titulo: boton.dataset.titulo,
                        tipo: boton.dataset.tipo,
                        estado: boton.dataset.estado,
                        puntuacion: boton.dataset.puntuacion,
                        fechaInicio: boton.dataset.fechaInicio,
                        fechaFin: boton.dataset.fechaFin,
                        notas: boton.dataset.notas,
                        portada: boton.dataset.portada,
                        banner: boton.dataset.banner,
                        favorito: boton.dataset.favorito
                    });

                    return;
                }

                if (objetivo.closest('#bibliotecaBotonFavorito')) {
                    actualizarFavorito(favoritoInput.value !== '1');
                    return;
                }

                if (objetivo.closest('[data-cerrar-modal]')) {
                    cerrarModal();
                }
            });

            notas.addEventListener('input', function () {
                contador.textContent = notas.value.length;
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.hidden) {
                    cerrarModal();
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener(
                'DOMContentLoaded',
                inicializarModalBiblioteca,
                { once: true }
            );
        } else {
            inicializarModalBiblioteca();
        }
    })();
</script>
