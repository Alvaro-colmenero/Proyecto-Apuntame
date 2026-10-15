<?php

namespace App\Http\Controllers;

// Importamos los modelos y las clases necesarias.
use App\Models\Contenido;
use App\Models\Genero;
use Illuminate\Http\Request;

// Controlador encargado de mostrar y consultar los contenidos.
class ContenidoController extends Controller
{
    // Muestra el listado de películas y series con filtros y paginación.
    public function index(Request $request)
    {
        // Recogemos los filtros enviados por la URL mediante GET.
        $tipo = $request->query('tipo');
        $busqueda = $request->query('buscar');
        $generoId = $request->query('genero');
        $anio = $request->query('anio');

        // Iniciamos la consulta y cargamos los géneros relacionados
        // para evitar consultas adicionales innecesarias.
        $consulta = Contenido::with('generos');

        // Filtramos por tipo si se ha seleccionado película o serie.
        if (in_array($tipo, ['pelicula', 'serie'], true)) {
            $consulta->where('tipo', $tipo);
        }

        // Si se ha introducido un texto, buscamos coincidencias
        // en el título del contenido.
        if (is_string($busqueda) && trim($busqueda) !== '') {
            $consulta->where(
                'titulo',
                'like',
                '%' . trim($busqueda) . '%'
            );
        }

        // Filtramos los contenidos que tengan asociado el género elegido.
        if (is_numeric($generoId)) {
            $consulta->whereHas('generos', function ($q) use ($generoId) {
                $q->where('generos.id', (int) $generoId);
            });
        }

        // Filtramos por año de estreno si el año está dentro
        // del intervalo permitido.
        if (
            is_numeric($anio) &&
            (int) $anio >= 1888 &&
            (int) $anio <= 2100
        ) {
            $consulta->whereYear('fecha_estreno', (int) $anio);
        }

        // Ordenamos los resultados alfabéticamente por título,
        // mostramos 12 contenidos por página y conservamos
        // los filtros al cambiar de página.
        $contenidos = $consulta
            ->orderBy('titulo', 'asc')
            ->paginate(24)
            ->withQueryString();

        // Obtenemos todos los géneros ordenados por nombre
        // para mostrarlos en el selector de filtros.
        $generos = Genero::orderBy('nombre')->get();

        // Obtenemos los años de estreno existentes, sin repetirlos,
        // ordenados del más reciente al más antiguo.
        $anios = Contenido::whereNotNull('fecha_estreno')
            ->selectRaw('YEAR(fecha_estreno) AS anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        // Enviamos los contenidos y los filtros a la vista
        // que muestra el catálogo.
        return view('contenidos.index', compact(
            'contenidos',
            'tipo',
            'busqueda',
            'generos',
            'generoId',
            'anio',
            'anios'
        ));
    }

    // Muestra la ficha con los detalles de un contenido concreto.
    public function show(Contenido $contenido)
    {
        // Cargamos los géneros, las temporadas y sus episodios.
        // Tanto las temporadas como los episodios se ordenan
        // por su número correspondiente.
        $contenido->load([
            'generos',
            'temporadas' => fn ($q) => $q->orderBy('numero'),
            'temporadas.episodios' => fn ($q) => $q->orderBy('numero'),
        ]);

        // Enviamos el contenido con sus relaciones a la vista de detalle.
        return view('contenidos.show', compact('contenido'));
    }
}
