<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{

    public function index(\Illuminate\Http\Request $request)
    {
        $tipo = $request->query('tipo');

        $consulta = \App\Models\Contenido::with('generos');

        if (in_array($tipo, ['pelicula', 'serie'], true)) {
            $consulta->where('tipo', $tipo);
        }

        $contenidos = $consulta
            ->orderBy('titulo', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('contenidos.index', compact('contenidos', 'tipo'));
    }


    public function show(Contenido $contenido)
    {
        $contenido->load([
            'generos',
            'temporadas' => function ($consulta) {
                $consulta->orderBy('numero');
            },
            'temporadas.episodios' => function ($consulta) {
                $consulta->orderBy('numero');
            },
        ]);

        return view('contenidos.show', compact('contenido'));
    }
}
