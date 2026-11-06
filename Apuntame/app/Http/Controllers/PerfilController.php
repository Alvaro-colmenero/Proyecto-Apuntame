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
