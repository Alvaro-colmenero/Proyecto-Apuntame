@extends('layouts.app')
@section('title', 'Inicio | MiCineSeries')
@section('content')

    <form class="filtros" method="GET" action="{{ route('contenidos.index') }}">
        <div class="campo">
            <label for="buscar">Buscar</label>
            <input id="buscar" name="buscar" type="search" value="{{ $busqueda }}" placeholder="Buscar título...">
        </div>

        <div class="campo">
            <label for="tipo">Formato</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="pelicula" @selected($tipo === 'pelicula')>
                    Películas
                </option>
                <option value="serie" @selected($tipo === 'serie')>
                    Series
                </option>
            </select>
        </div>

        <div class="campo">
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                @foreach ($generos as $genero)
                    <option value="{{ $genero->id }}"@selected((string) $generoId === (string) $genero->id)>
                        {{ $genero->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="campo">
            <label for="anio">Año</label>
            <select id="anio" name="anio">
                <option value="">Todos</option>
                @foreach ($anios as $a)
                    <option value="{{ $a }}"@selected((string) $anio === (string) $a)>
                        {{ $a }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="campo">
            <label>&nbsp;</label>
            <button class="boton" type="submit">Filtrar</button>
        </div>
    </form>

    @if ($busqueda || $tipo || $generoId || $anio)

        <section class="seccion">
            <div class="titulo-seccion">
                <h2>RESULTADOS</h2>
                <a class="ver-todo" href="{{ route('contenidos.index') }}">
                    Limpiar filtros
                </a>
            </div>
            @include('contenidos._tarjetas', [ 'lista' => $contenidos->getCollection()  ])

            <div class="paginacion">
                {{ $contenidos->links() }}
            </div>
        </section>

    @else

        {{-- CARRUSEL DE TENDENCIAS --}}
        @php
            $tendencias = $contenidos->getCollection()
                ->shuffle()
                ->take(15)
                ->values();
        @endphp

        @if ($tendencias->isNotEmpty())
            <section class="seccion seccion-tendencias">
                <div class="titulo-seccion">
                    <div>
                        <h2>TENDENCIAS</h2>
                        <p class="subtitulo-tendencias">
                            Descubre películas y series al azar
                        </p>
                    </div>

                    <div class="controles-tendencias">
                        <button type="button" class="flecha-tendencias" data-carrusel-anterior aria-label="Tendencias anteriores">
                            &#10094;
                        </button>

                        <button type="button" class="flecha-tendencias" data-carrusel-siguiente aria-label="Tendencias siguientes">
                            &#10095;
                        </button>
                    </div>
                </div>

                <div class="carrusel-tendencias" data-carrusel-tendencias tabindex="0" aria-label="Carrusel de películas y series">
                    <div class="carrusel-tendencias-pista">
                        @include('contenidos._tarjetas', ['lista' => $tendencias,'modoCarrusel' => true ])
                    </div>
                </div>

                <div class="indicadores-tendencias" data-indicadores-tendencias aria-label="Posición del carrusel"></div>
            </section>
        @endif

        {{-- RESTO DEL CATÁLOGO --}}
        <section class="seccion">
            <div class="titulo-seccion">
                <h2>PELÍCULAS Y SERIES</h2>

                <a class="ver-todo" href="{{ route('contenidos.index') }}">
                    Ver todo →
                </a>
            </div>

            @include('contenidos._tarjetas', [  'lista' => $contenidos->getCollection()->slice(12, 12) ])
        </section>

        <div class="paginacion">
            {{ $contenidos->links() }}
        </div>

    @endif

@endsection


<script>

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-carrusel-tendencias]').forEach(function (carrusel) {
            if (carrusel.dataset.inicializado === '1') return;
            carrusel.dataset.inicializado = '1';

            const seccion = carrusel.closest('.seccion-tendencias');
            const pista = carrusel.querySelector('.tarjetas-carrusel');
            const anterior = seccion.querySelector('[data-carrusel-anterior]');
            const siguiente = seccion.querySelector('[data-carrusel-siguiente]');
            const indicadores = seccion.querySelector('[data-indicadores-tendencias]');

            if (!pista || !indicadores) return;

            const originales = Array.from(pista.children);
            const total = originales.length;

            if (total < 2) return;

            let indice = 0;
            let temporizador = null;
            let pausado = false;
            let moviendo = false;

            // Clonar tarjetas para crear el efecto infinito.
            const clonesInicio = originales.map(function (tarjeta) {
                const clon = tarjeta.cloneNode(true);
                clon.setAttribute('aria-hidden', 'true');

                clon.querySelectorAll('a, button, input, select, textarea').forEach(el => {
                    el.setAttribute('tabindex', '-1');
                });

                return clon;
            });

            const clonesFinal = originales.map(function (tarjeta) {
                const clon = tarjeta.cloneNode(true);
                clon.setAttribute('aria-hidden', 'true');

                clon.querySelectorAll('a, button, input, select, textarea').forEach(el => {
                    el.setAttribute('tabindex', '-1');
                });

                return clon;
            });

            clonesFinal.reverse().forEach(clon => {
                pista.insertBefore(clon, pista.firstChild);
            });

            clonesInicio.forEach(clon => pista.appendChild(clon));

            const tarjetas = Array.from(pista.children);

            // Crear indicadores.
            indicadores.innerHTML = '';

            originales.forEach(function (_, i) {
                const punto = document.createElement('button');
                punto.type = 'button';
                punto.className = 'indicador-tendencias';
                punto.setAttribute('aria-label', 'Mostrar grupo ' + (i + 1));

                punto.addEventListener('click', function () {
                    irA(i);
                    reiniciar();
                });

                indicadores.appendChild(punto);
            });

            const puntos = Array.from(indicadores.children);

            function posicion(i) {
                return tarjetas[i].offsetLeft - pista.offsetLeft;
            }

            function actualizarIndicadores() {
                const activo = ((indice % total) + total) % total;

                puntos.forEach(function (punto, i) {
                    punto.classList.toggle('activo', i === activo);
                });
            }

            function irA(i) {
                if (moviendo) return;

                indice = i;
                moviendo = true;

                pista.style.transition = 'transform 0.5s ease';
                pista.style.transform =
                    `translateX(${-posicion(total + indice)}px)`;

                actualizarIndicadores();
            }

            function mover(direccion) {
                if (moviendo) return;

                indice += direccion;
                moviendo = true;

                pista.style.transition = 'transform 0.5s linear';
                pista.style.transform =
                    `translateX(${-posicion(total + indice)}px)`;

                actualizarIndicadores();
            }

            // Posición inicial.
            function inicializarPosicion() {
                pista.style.transition = 'none';
                pista.style.transform =
                    `translateX(${-posicion(total)}px)`;

                actualizarIndicadores();
            }

            // Gestionar el bucle infinito.
            pista.addEventListener('transitionend', function (e) {
                if (e.propertyName !== 'transform') return;

                if (indice >= total) {
                    indice = 0;
                    inicializarPosicion();
                }

                if (indice < 0) {
                    indice = total - 1;
                    inicializarPosicion();
                }

                moviendo = false;
                actualizarIndicadores();
            });

            // Reproducción automática.
            function iniciar() {
                if (temporizador || pausado || total < 2) return;

                temporizador = setInterval(function () {
                    mover(1);
                }, 2000);
            }

            function detener() {
                clearInterval(temporizador);
                temporizador = null;
            }

            function reiniciar() {
                detener();
                iniciar();
            }

            // Botón anterior.
            if (anterior) {
                anterior.addEventListener('click', function () {
                    mover(-1);
                });
            }

            // Botón siguiente.
            if (siguiente) {
                siguiente.addEventListener('click', function () {
                    mover(1);
                });
            }

            // PAUSAR ÚNICAMENTE AL PASAR EL RATÓN SOBRE EL CARRUSEL.
            carrusel.addEventListener('mouseenter', function () {
                pausado = true;
                detener();
            });

            carrusel.addEventListener('mouseleave', function () {
                pausado = false;
                iniciar();
            });

            // Control de visibilidad de la pestaña.
            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    detener();
                } else {
                    iniciar();
                }
            });

            // Recalcular posiciones al cambiar el tamaño.
            window.addEventListener('resize', inicializarPosicion);

            // Inicializar.
            inicializarPosicion();
            iniciar();
        });
    });

</script>
