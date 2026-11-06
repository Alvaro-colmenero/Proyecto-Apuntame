<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PerfilController extends Controller
{

    public function index()
    {
        $usuarioPerfil = auth()->user();

        $contenidosPerfil = DB::table('biblioteca')
        ->join('contenidos', 'biblioteca.contenido_id', '=', 'contenidos.id')
        ->where('biblioteca.usuario_id', $usuarioPerfil->id)
        ->select(
            'contenidos.*',
            'biblioteca.estado',
            'biblioteca.notas',
            'biblioteca.puntuacion',
            'biblioteca.fecha_inicio',
            'biblioteca.fecha_fin',
            'biblioteca.favorito as favorito'
        )
        ->selectSub(function ($query) {
            $query->from('temporadas')
                ->join(
                    'episodios',
                    'episodios.temporada_id',
                    '=',
                    'temporadas.id'
                )
                ->whereColumn(
                    'temporadas.contenido_id',
                    'contenidos.id'
                )
                ->selectRaw('COUNT(episodios.id)');
        }, 'max_episodios')
        ->selectSub(function ($query) use ($usuarioPerfil) {
            $query->from('temporadas')
                ->join(
                    'episodios',
                    'episodios.temporada_id',
                    '=',
                    'temporadas.id'
                )
                ->join(
                    'episodios_vistos',
                    'episodios_vistos.episodio_id',
                    '=',
                    'episodios.id'
                )
                ->whereColumn(
                    'temporadas.contenido_id',
                    'contenidos.id'
                )
                ->where(
                    'episodios_vistos.usuario_id',
                    $usuarioPerfil->id
                )
                ->selectRaw('COUNT(episodios_vistos.episodio_id)');
        }, 'episodios_vistos_usuario')
        ->get();


            $peliculasPerfil = $this->obtenerBibliotecaPorTipo(
                auth()->id(),
                'pelicula'
            );

            $seriesPerfil = $this->obtenerBibliotecaPorTipo(
                auth()->id(),
                'serie'
            );

            $favoritosPerfil = DB::table('biblioteca')
                ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
                ->where('biblioteca.usuario_id', $usuarioPerfil->id)
                ->where('biblioteca.favorito', 1)
                ->select(
                    'contenidos.id',
                    'contenidos.titulo',
                    'contenidos.tipo',
                    'contenidos.poster',
                    'contenidos.fecha_estreno'
                )
                ->orderByDesc('contenidos.id')
                ->limit(6)
                ->get();

            $estadosBiblioteca = [
                'pendiente' => 'Pendientes',
                'viendo' => 'Viendo',
                'vista' => 'Vistas',
                'pausada' => 'Pausadas',
                'abandonada' => 'Abandonadas',
            ];

        
        // =========================================
        // ESTADÍSTICAS DE LA BIBLIOTECA
        // =========================================

        $estadisticas = [];

        // Cantidad de películas y series
        $estadisticas['total_peliculas'] = DB::table('biblioteca')
            ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
            ->where('biblioteca.usuario_id', $usuarioPerfil->id)
            ->where('contenidos.tipo', 'pelicula')
            ->count();

        $estadisticas['total_series'] = DB::table('biblioteca')
            ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
            ->where('biblioteca.usuario_id', $usuarioPerfil->id)
            ->where('contenidos.tipo', 'serie')
            ->count();

        $estadisticas['total_contenidos'] =
            $estadisticas['total_peliculas'] + $estadisticas['total_series'];

        // Episodios vistos
        $estadisticas['episodios_vistos'] = DB::table('episodios_vistos')
            ->where('usuario_id', $usuarioPerfil->id)
            ->count();

        // Películas finalizadas
        $estadisticas['peliculas_vistas'] = DB::table('biblioteca')
            ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
            ->where('biblioteca.usuario_id', $usuarioPerfil->id)
            ->where('contenidos.tipo', 'pelicula')
            ->where('biblioteca.estado', 'vista')
            ->count();

        // Series con algún episodio visto
        $estadisticas['series_empezadas'] = DB::table('episodios_vistos')
            ->join('episodios', 'episodios.id', '=', 'episodios_vistos.episodio_id')
            ->join('temporadas', 'temporadas.id', '=', 'episodios.temporada_id')
            ->join('contenidos', 'contenidos.id', '=', 'temporadas.contenido_id')
            ->where('episodios_vistos.usuario_id', $usuarioPerfil->id)
            ->distinct()
            ->count('contenidos.id');

        // Tiempo de visualización en minutos
        $minutosPeliculas = 0;

        // Comprobar si contenidos tiene una columna de duración.
        // Se presupone que su unidad es minutos.
        if (\Illuminate\Support\Facades\Schema::hasColumn('contenidos', 'duracion')) {
            $minutosPeliculas = (int) DB::table('biblioteca')
                ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
                ->where('biblioteca.usuario_id', $usuarioPerfil->id)
                ->where('contenidos.tipo', 'pelicula')
                ->where('biblioteca.estado', 'vista')
                ->sum('contenidos.duracion');
        }

        // Duración de los episodios vistos.
        // Se presupone que episodios.duracion está expresada en minutos.
        $minutosEpisodios = (int) DB::table('episodios_vistos')
            ->join('episodios', 'episodios.id', '=', 'episodios_vistos.episodio_id')
            ->where('episodios_vistos.usuario_id', $usuarioPerfil->id)
            ->sum('episodios.duracion');

        $estadisticas['minutos_vistos'] =
            $minutosPeliculas + $minutosEpisodios;

        $estadisticas['horas_vistas'] =
            round($estadisticas['minutos_vistos'] / 60, 1);

        $estadisticas['dias_vistos'] =
            round($estadisticas['minutos_vistos'] / 1440, 2);

        // Géneros más vistos: contenidos finalizados o series con episodios vistos
        $generosMasVistos = DB::table('biblioteca')
            ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
            ->join('contenidos_generos', 'contenidos_generos.contenido_id', '=', 'contenidos.id')
            ->join('generos', 'generos.id', '=', 'contenidos_generos.genero_id')
            ->where('biblioteca.usuario_id', $usuarioPerfil->id)
            ->where(function ($query) use ($usuarioPerfil) {
                $query->where(function ($q) {
                    $q->where('contenidos.tipo', 'pelicula')
                    ->where('biblioteca.estado', 'vista');
                })
                ->orWhere(function ($q) use ($usuarioPerfil) {
                    $q->where('contenidos.tipo', 'serie')
                    ->whereExists(function ($subquery) use ($usuarioPerfil) {
                        $subquery->select(DB::raw(1))
                            ->from('temporadas')
                            ->join('episodios', 'episodios.temporada_id', '=', 'temporadas.id')
                            ->join('episodios_vistos', 'episodios_vistos.episodio_id', '=', 'episodios.id')
                            ->whereColumn('temporadas.contenido_id', 'contenidos.id')
                            ->where('episodios_vistos.usuario_id', $usuarioPerfil->id);
                    });
                });
            })
            ->select('generos.nombre', DB::raw('COUNT(DISTINCT contenidos.id) as total'))
            ->groupBy('generos.id', 'generos.nombre')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Estados de la biblioteca
        $estadisticas['estados'] = DB::table('biblioteca')
            ->where('usuario_id', $usuarioPerfil->id)
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();

        $estadisticas['generos'] = $generosMasVistos;

        // Máximo para calcular los porcentajes de las barras
        $estadisticas['max_genero'] = max( 1,(int) $generosMasVistos->max('total')
        );


        return view('perfil.index', [
            'usuarioPerfil' => $usuarioPerfil,
            'contenidosPerfil' => $contenidosPerfil,
            'generosPerfil' => collect(),
            'generosEstadisticas' => collect(),
            'actividadPerfil' => collect(),
            'peliculasPerfil' => $peliculasPerfil,
            'seriesPerfil' => $seriesPerfil,
            'favoritosPerfil' => $favoritosPerfil,
            'estadosBiblioteca' => $estadosBiblioteca,
            'estadisticas' => $estadisticas,
            
        ]);

    }


    public function actualizar(Request $request)
    {
        $usuario = $request->user();

        $request->validate([
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'banner' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        foreach (['avatar', 'banner'] as $campo) {
            if (!$request->hasFile($campo)) {
                continue;
            }

            $archivo = $request->file($campo);
            $carpeta = public_path("images/usuario/{$campo}");

            if (!File::isDirectory($carpeta)) {
                File::makeDirectory($carpeta, 0755, true);
            }

            // El ID del usuario será el nombre de la imagen.
            $nombreArchivo = $usuario->id . '.' . $archivo->extension();

            // Elimina la imagen anterior si tenía otra extensión.
            $rutaAnterior = $usuario->{$campo} ? public_path($usuario->{$campo}) : null;
            $rutaNueva = $carpeta . DIRECTORY_SEPARATOR . $nombreArchivo;

            if ($rutaAnterior && is_file($rutaAnterior) && realpath(dirname($rutaAnterior)) === realpath($carpeta) && realpath($rutaAnterior) !== realpath($rutaNueva)) {
                File::delete($rutaAnterior);
            }

            // Sobrescribe la imagen si ya existe.
            $archivo->move($carpeta, $nombreArchivo);

            // Guarda la ruta relativa en el VARCHAR existente.
            $usuario->{$campo} = "images/usuario/{$campo}/{$nombreArchivo}";
        }

        $usuario->save();

    }


    
    private function obtenerBibliotecaPorTipo(int $usuarioId, string $tipo)
    {
        return DB::table('biblioteca')
            ->join('contenidos', 'contenidos.id', '=', 'biblioteca.contenido_id')
            ->where('biblioteca.usuario_id', $usuarioId)
            ->where('contenidos.tipo', $tipo)
            ->select(
                'contenidos.*',
                'biblioteca.estado as estado_usuario',
                'biblioteca.puntuacion',
                'biblioteca.fecha_inicio',
                'biblioteca.fecha_fin',
                'biblioteca.notas',
                'biblioteca.favorito as favorito'
            )

            // Total de episodios que tiene la serie
            ->selectSub(function ($query) {
                $query->from('temporadas')
                    ->join(
                        'episodios',
                        'episodios.temporada_id',
                        '=',
                        'temporadas.id'
                    )
                    ->whereColumn(
                        'temporadas.contenido_id',
                        'contenidos.id'
                    )
                    ->selectRaw('COUNT(episodios.id)');
            }, 'max_episodios')

            // Episodios que ha visto el usuario
            ->selectSub(function ($query) use ($usuarioId) {
                $query->from('temporadas')
                    ->join(
                        'episodios',
                        'episodios.temporada_id',
                        '=',
                        'temporadas.id'
                    )
                    ->join(
                        'episodios_vistos',
                        'episodios_vistos.episodio_id',
                        '=',
                        'episodios.id'
                    )
                    ->whereColumn(
                        'temporadas.contenido_id',
                        'contenidos.id'
                    )
                    ->where(
                        'episodios_vistos.usuario_id',
                        $usuarioId
                    )
                    ->selectRaw('COUNT(episodios_vistos.episodio_id)');
            }, 'episodios_vistos_usuario')

            // Géneros del contenido
            ->selectSub(function ($query) {
                $query->from('contenidos_generos')
                    ->join(
                        'generos',
                        'generos.id',
                        '=',
                        'contenidos_generos.genero_id'
                    )
                    ->whereColumn(
                        'contenidos_generos.contenido_id',
                        'contenidos.id'
                    )
                    ->selectRaw(
                        "GROUP_CONCAT(generos.nombre SEPARATOR '|')"
                    );
            }, 'generos')

            ->orderBy('contenidos.titulo')
            ->get()
            ->groupBy(function ($contenido) {
                $estadosValidos = [
                    'pendiente',
                    'viendo',
                    'vista',
                    'pausada',
                    'abandonada',
                ];

                return in_array(
                    $contenido->estado_usuario,
                    $estadosValidos,
                    true
                )
                    ? $contenido->estado_usuario
                    : 'pendiente';
            });
    }


}
