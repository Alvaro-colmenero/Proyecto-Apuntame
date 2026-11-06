<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BibliotecaController extends Controller
{

    public function index()
{
    $contenidos = DB::table('biblioteca')
        ->join('contenidos', 'biblioteca.contenido_id', '=', 'contenidos.id')
        ->where('biblioteca.usuario_id', auth()->id())
        ->select(
            'contenidos.*',
            'biblioteca.estado',
            'biblioteca.puntuacion',
            'biblioteca.fecha_inicio',
            'biblioteca.fecha_fin',
            'biblioteca.notas',
            'biblioteca.favorito'
        )
        ->selectSub(function ($query) {
            $query->from('temporadas')
                ->join('episodios', 'episodios.temporada_id', '=', 'temporadas.id')
                ->whereColumn('temporadas.contenido_id', 'contenidos.id')
                ->selectRaw('COUNT(episodios.id)');
        }, 'max_episodios')
        ->selectSub(function ($query) {
            $query->from('temporadas')
                ->join('episodios', 'episodios.temporada_id', '=', 'temporadas.id')
                ->join('episodios_vistos', 'episodios_vistos.episodio_id', '=', 'episodios.id')
                ->whereColumn('temporadas.contenido_id', 'contenidos.id')
                ->where('episodios_vistos.usuario_id', auth()->id())
                ->selectRaw('COUNT(episodios_vistos.episodio_id)');
        }, 'episodios_vistos_usuario')
        ->get();

    return view('perfil.index', [
        'contenidos' => $contenidos
    ]);
}

    public function guardar(Request $request)
    {
        // Validar los datos generales del formulario
        $datos = $request->validate([
            'contenido_id' => ['required', 'integer', 'exists:contenidos,id'],
            'estado' => ['required', 'in:pendiente,viendo,vista,pausada,abandonada'],
            'puntuacion' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'notas' => ['nullable', 'string', 'max:5000'],
            'favorito' => ['required', 'boolean'],
        ]);

        // Obtener el contenido
        $contenido = DB::table('contenidos')
            ->where('id', $datos['contenido_id'])
            ->first();

        // Las películas no pueden estar en estado "viendo"
        if ($contenido->tipo === 'pelicula' && $datos['estado'] === 'viendo') {
            return back()
                ->withErrors([
                    'estado' => 'Una película no puede tener el estado Viendo.',
                ])
                ->withInput();
        }

        // Inicializar las variables de episodios
        $episodios = collect();
        $numeroEpisodiosVistos = 0;

        // Si es una serie, obtener y validar sus episodios
        if ($contenido->tipo === 'serie') {

            $episodios = DB::table('episodios')
                ->join(
                    'temporadas',
                    'episodios.temporada_id',
                    '=',
                    'temporadas.id'
                )
                ->where('temporadas.contenido_id', $contenido->id)
                ->orderBy('temporadas.numero')
                ->orderBy('episodios.numero')
                ->select('episodios.id')
                ->pluck('episodios.id');

            $totalEpisodios = $episodios->count();

            // Validar el número de episodios vistos
            $datosEpisodios = $request->validate([
                'episodios_vistos' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:' . $totalEpisodios,
                ],
            ]);

            $numeroEpisodiosVistos = (int) $datosEpisodios['episodios_vistos'];

        } else {

            // Las películas no pueden recibir episodios vistos
            if ($request->exists('episodios_vistos')) {
                return back()
                    ->withErrors([
                        'episodios_vistos' => 'Solo puedes indicar episodios vistos en las series.',
                    ])
                    ->withInput();
            }
        }

        // Guardar todo dentro de una transacción
        DB::transaction(function () use (
            $request,
            $datos,
            $contenido,
            $episodios,
            $numeroEpisodiosVistos
        ) {

            // Guardar o actualizar el contenido en la biblioteca
            DB::table('biblioteca')->updateOrInsert(
                [
                    'usuario_id' => $request->user()->id,
                    'contenido_id' => $contenido->id,
                ],
                [
                    'estado' => $datos['estado'],
                    'puntuacion' => $datos['puntuacion'] ?? null,
                    'fecha_inicio' => $datos['fecha_inicio'] ?? null,
                    'fecha_fin' => $datos['fecha_fin'] ?? null,
                    'notas' => $datos['notas'] ?? null,
                    'favorito' => (int) $request->boolean('favorito'),
                ]
            );

            // Actualizar episodios vistos si es una serie
            if ($contenido->tipo === 'serie') {

                // Eliminar los episodios vistos anteriormente de esta serie
                if ($episodios->isNotEmpty()) {
                    DB::table('episodios_vistos')
                        ->where('usuario_id', $request->user()->id)
                        ->whereIn('episodio_id', $episodios)
                        ->delete();
                }

                // Seleccionar los primeros N episodios
                $episodiosSeleccionados = $episodios
                    ->take($numeroEpisodiosVistos);

                // Preparar los registros
                $registros = [];

                foreach ($episodiosSeleccionados as $episodioId) {
                    $registros[] = [
                        'usuario_id' => $request->user()->id,
                        'episodio_id' => $episodioId,
                        'fecha_visto' => now(),
                    ];
                }

                // Insertar los episodios vistos
                if (!empty($registros)) {
                    DB::table('episodios_vistos')->insert($registros);
                }
            }
        });

        return back()->with(
            'success',
            'Tu biblioteca se ha actualizado.'
        );
    }
}
