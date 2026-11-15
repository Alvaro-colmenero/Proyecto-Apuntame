<!--
+----------------------------------------------+
|¿Qué es esto?                            _ ▄ x|
+----------------------------------------------+
|Esta es la página principal de la aplicación, |
|Aquí se encuentra todo el catálogo, incluyendo|
|un carrusel para las películas, por ejemplo.  |
+----------------------------------------------+
-->
@extends('layouts.app')
@section('title', 'Inicio | MiCineSeries')
@section('content')

    <!--
    Todo el formulario se encarga de filtrar
    los datos para que se muestren de acuerdo con
    los que se especifiquen
    -->
    <form class="filtros" method="GET" action="{{ route('contenidos.index') }}">
        <!--Se encarga de buscar todo el contendio que contenga lo que se introduce en el campo-->
        <div class="campo">
            <label for="buscar">Buscar</label>
            <input id="buscar" name="buscar" type="search" value="{{ $busqueda }}" placeholder="Buscar título...">
        </div>

        <!--
        Este es el desplegable de formato, en función de la opción
        que se haya tomado se mostrarán el contenido de acuerdo con este
        -->
        <div class="campo">
            <!--El _selected sirve para hacer un select a la base de datos-->
            <label for="tipo">Formato</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <!--En este caso su traducción literal sería algo así:
                    "Selecciona todo el contenido cuyo contenido sea exactamente igual
                    a pelicula"
                -->
                <option value="pelicula" @selected($tipo === 'pelicula')>
                    Películas
                </option>
                <option value="serie" @selected($tipo === 'serie')>
                    Series
                </option>
            </select>
        </div>
        <!--
        Es exactamente el mismo funcionamiento que el campo anteriore de formato,
        tan solo que para cada género se le aplica un select en específico.
        -->
        <div class="campo">
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <!--
                Para que se muestre una lista con tódos los géneros, se hace un
                for each de la tabla de géneros, y se estraen los valores del nombre
                de cada uno de estos.
                -->
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

    <!--
    En el caso en el que se haya seleccionado algúno de los filtros
    (Por eso el if, porque si no se ha seleccionado un filtro, valdrían null)
    -->
    @if ($busqueda || $tipo || $generoId || $anio)

        <section class="seccion">
            <div class="titulo-seccion">
                <h2>RESULTADOS</h2>
                <!--
                Se pasa toda la información al archivo web.php, que este
                se pone en contacto con el controlador de los contenidos
                -->
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
                ->take(15) //se ponen 15 elemenots en el carrusel
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
                    <!--
                    Botones destinados a pasar de una película a otra,
                    estos serán eliminados en futuras actualizaciones de la página

                    <div class="controles-tendencias">
                        <button type="button" class="flecha-tendencias" data-carrusel-anterior aria-label="Tendencias anteriores">
                            &#10094;
                        </button>

                        <button type="button" class="flecha-tendencias" data-carrusel-siguiente aria-label="Tendencias siguientes">
                            &#10095;
                        </button>
                    </div>
                    -->
                </div>

                <div class="carrusel-tendencias" data-carrusel-tendencias tabindex="0" aria-label="Carrusel de películas y series">
                    <div class="carrusel-tendencias-pista">
                        <!--
                        A cada elemento presente en el carrusel,
                        se le aplicará el estilo presente en _tarjetas.blade.php.
                        Le pasa la variable $tendencias con el nombre de lista, y a la variable
                        'modoCarrusel', le asigna el valor verdadero
                        -->
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
            <!--Le pasa a _tarjetas.blade.php la variable contenidos, determinando que sea de tamaño 12 x 12-->
            @include('contenidos._tarjetas', [  'lista' => $contenidos->getCollection()->slice(12, 12) ])
        </section>

        <div class="paginacion">
            {{ $contenidos->links() }}
        </div>

    @endif

@endsection


<script>
    //Se le añade un listener a la página para cuando carge
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-carrusel-tendencias]').forEach(function (carrusel) {
            //En el caso que ya exista un carrusel y se haya inicializado,
            //no se sigue con la ejecución del programa
            if (carrusel.dataset.inicializado === '1') return;
            carrusel.dataset.inicializado = '1';

            const seccion = carrusel.closest('.seccion-tendencias');
            const pista = carrusel.querySelector('.tarjetas-carrusel');
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

                pista.style.transition = 'transform 1.5s ease';
                pista.style.transform =
                    `translateX(${-posicion(total + indice)}px)`;

                actualizarIndicadores();
            }

            function mover(direccion) {
                if (moviendo) return;

                indice += direccion;
                moviendo = true;

                pista.style.transition = 'transform 3s linear';
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
                }, 0);
            }

            function detener() {
                clearInterval(temporizador);
                temporizador = null;
            }

            function reiniciar() {
                detener();
                iniciar();
            }
/*
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
*/
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
