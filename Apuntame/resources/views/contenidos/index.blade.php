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

            const pista = carrusel.querySelector('.tarjetas-carrusel');
            const anterior = carrusel.closest('.seccion-tendencias').querySelector('[data-carrusel-anterior]');
            const siguiente = carrusel.closest('.seccion-tendencias').querySelector('[data-carrusel-siguiente]');
            const indicadores = carrusel.closest('.seccion-tendencias').querySelector('[data-indicadores-tendencias]');

            if (!pista) return;

            const tarjetas = Array.from(pista.children);
            if (!tarjetas.length) return;

            let indice = 0;
            let temporizador = null;

            tarjetas.forEach(function (_, i) {
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

            function paso() {
                if (tarjetas.length < 2) return 0;

                const separacion = parseFloat(getComputedStyle(pista).gap) || 0;

                return tarjetas[0].getBoundingClientRect().width + separacion;
            }

            function actualizarIndicadores() {
                const maxScroll = carrusel.scrollWidth - carrusel.clientWidth;
                const progreso = maxScroll > 0 ? carrusel.scrollLeft / maxScroll : 0;
                const indice = Math.round(progreso * (indicadores.length - 1));
                indicadores.forEach((indicador, i) => {
                    indicador.classList.toggle('activo', i === indice);
                });
            }

            function irA(i) {
                const distancia = paso();
                if (!distancia) return;
                indice = (i + tarjetas.length) % tarjetas.length;
                carrusel.scrollTo({
                    left: tarjetas[indice].offsetLeft - tarjetas[0].offsetLeft,
                    behavior: 'smooth'
                });

                actualizarIndicadores();
            }

            function mover(direccion) {
                const distancia = paso();
                if (!distancia) return;

                const maximo = carrusel.scrollWidth - carrusel.clientWidth;

                if (direccion > 0 && carrusel.scrollLeft >= maximo - 2) {
                    carrusel.scrollTo({ left: 0, behavior: 'smooth' });
                } else if (direccion < 0 && carrusel.scrollLeft <= 2) {
                    carrusel.scrollTo({ left: maximo, behavior: 'smooth' });
                } else {
                    carrusel.scrollBy({
                        left: distancia * direccion,
                        behavior: 'smooth'
                    });
                }
            }

            function iniciar() {
                detener();
                if (tarjetas.length > 1) {
                    temporizador = setInterval(function () {
                        mover(1);
                    }, 4000);
                }
            }

            function detener() {
                if (temporizador) {
                    clearInterval(temporizador);
                    temporizador = null;
                }
            }

            function reiniciar() {
                detener();
                iniciar();
            }

            anterior.addEventListener('click', function () {
                mover(-1);
                reiniciar();
            });

            siguiente.addEventListener('click', function () {
                mover(1);
                reiniciar();
            });

            carrusel.addEventListener('scroll', actualizarIndicadores, {
                passive: true
            });

            carrusel.addEventListener('mouseenter', detener);
            carrusel.addEventListener('mouseleave', iniciar);
            carrusel.addEventListener('focusin', detener);
            carrusel.addEventListener('focusout', iniciar);
            carrusel.addEventListener('touchstart', detener, { passive: true });
            carrusel.addEventListener('touchend', iniciar, { passive: true });

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    detener();
                } else {
                    iniciar();
                }
            });

            actualizarIndicadores();
            iniciar();
        });
    });

</script>
