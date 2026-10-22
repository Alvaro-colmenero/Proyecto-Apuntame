
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">

<div id="modalBiblioteca" class="modal-biblioteca" hidden>
    <div class="modal-biblioteca-fondo" data-cerrar-modal></div>

    <div class="modal-biblioteca-contenido" role="dialog" aria-modal="true" aria-labelledby="modalBibliotecaTitulo">

        <button type="button" class="modal-biblioteca-cerrar" data-cerrar-modal aria-label="Cerrar modal">
            &times;
        </button>

        {{-- Banner --}}
        <div id="bibliotecaBanner" class="biblioteca-banner"></div>

        {{-- Portada e información --}}
        <div class="biblioteca-cabecera">
            <img id="bibliotecaPortada" class="biblioteca-portada" src="" alt="" hidden>

            <div class="biblioteca-cabecera-texto">
                <span id="bibliotecaTipo" class="etiqueta"></span>
                <h2 id="modalBibliotecaTitulo">Mi biblioteca</h2>
                <p id="modalBibliotecaNombre" class="descripcion"></p>
            </div>
        </div>

        <form method="POST" action="{{ route('biblioteca.guardar') }}">
            @csrf

            <input type="hidden" name="contenido_id" id="bibliotecaContenidoId">

            <label for="bibliotecaEstado">Estado</label>
            <select name="estado" id="bibliotecaEstado" required>
                <option value="pendiente">Pendiente</option>
                <option value="viendo" data-solo-serie>Viendo</option>
                <option value="vista">Vista</option>
                <option value="pausada">Pausada</option>
                <option value="abandonada">Abandonada</option>
            </select>

            <label for="bibliotecaNotas">Mis notas personales</label>
            <textarea name="notas" id="bibliotecaNotas" rows="4" maxlength="5000" placeholder="¿Qué te parece? ¿Por qué quieres verla? ¿En qué episodio te quedaste?"></textarea>

            <div class="biblioteca-contador">
                <span id="bibliotecaCaracteres">0</span>/5000 caracteres
            </div>

            <div class="modal-biblioteca-acciones">
                <button type="button" class="boton boton-secundario" data-cerrar-modal>
                    Cancelar
                </button>

                <button type="submit" class="boton">
                    Guardar en mi lista
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalBiblioteca');

        if (!modal || modal.dataset.inicializado) return;
        modal.dataset.inicializado = 'true';

        const idInput = document.getElementById('bibliotecaContenidoId');
        const titulo = document.getElementById('modalBibliotecaTitulo');
        const nombre = document.getElementById('modalBibliotecaNombre');
        const tipoTexto = document.getElementById('bibliotecaTipo');
        const estado = document.getElementById('bibliotecaEstado');
        const notas = document.getElementById('bibliotecaNotas');
        const contador = document.getElementById('bibliotecaCaracteres');
        const banner = document.getElementById('bibliotecaBanner');
        const portada = document.getElementById('bibliotecaPortada');
        const opcionViendo = estado.querySelector('[data-solo-serie]');

        function abrirModal(datos) {
            idInput.value = datos.id || '';
            titulo.textContent = datos.titulo || 'Mi biblioteca';
            nombre.textContent = datos.titulo || '';

            const esSerie = datos.tipo === 'serie';
            tipoTexto.textContent = esSerie ? 'Serie' : 'Película';

            opcionViendo.hidden = !esSerie;
            opcionViendo.disabled = !esSerie;

            estado.value = datos.estado || 'pendiente';

            if (!esSerie && estado.value === 'viendo') {
                estado.value = 'pendiente';
            }

            notas.value = datos.notas || '';
            contador.textContent = notas.value.length;

            banner.style.backgroundImage = datos.banner
                ? `url("${datos.banner}")`
                : 'none';

            if (datos.portada) {
                portada.src = datos.portada;
                portada.alt = 'Portada de ' + (datos.titulo || '');
                portada.hidden = false;
            } else {
                portada.removeAttribute('src');
                portada.alt = '';
                portada.hidden = true;
            }

            modal.hidden = false;
            document.body.style.overflow = 'hidden';
        }

        function cerrarModal() {
            modal.hidden = true;
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (event) {
            const boton = event.target.closest('[data-abrir-biblioteca]');

            if (boton) {
                event.preventDefault();

                abrirModal({
                    id: boton.dataset.id,
                    titulo: boton.dataset.titulo,
                    tipo: boton.dataset.tipo,
                    estado: boton.dataset.estado,
                    notas: boton.dataset.notas,
                    portada: boton.dataset.portada,
                    banner: boton.dataset.banner
                });

                return;
            }

            if (event.target.closest('[data-cerrar-modal]')) {
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
    });
</script>
