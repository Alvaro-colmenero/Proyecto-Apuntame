<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BibliotecaController extends Controller
{
    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'contenido_id' => ['required', 'integer', 'exists:contenidos,id'],
            'estado' => ['required', 'in:pendiente,viendo,visto,pausada,abandonada',],
            'notas' => ['nullable', 'string', 'max:5000'],
        ]);

        $contenido = DB::table('contenidos')
            ->where('id', $datos['contenido_id'])
            ->first();

        if ($contenido->tipo === 'pelicula' && $datos['estado'] === 'viendo') {
            throw ValidationException::withMessages([
                'estado' => 'Una película no puede tener el estado Viendo.',
            ]);
        }

        $registro = [
            'estado' => $datos['estado'],
            'notas' => $datos['notas'] ?? null,
        ];

        DB::table('biblioteca')->updateOrInsert(
            ['usuario_id' => $request->user()->id, 'contenido_id' => $contenido->id,],
            $registro
        );


        $request->validate([
            'contenido_id' => ['required', 'integer', 'exists:contenidos,id'],
            'estado' => ['required', 'in:pendiente,viendo,vista,pausada,abandonada'],
            'puntuacion' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'notas' => ['nullable', 'string', 'max:5000'],
            'favorito' => ['required', 'boolean'],
        ]);

        $esSerie = DB::table('contenidos')
                ->where('id', $request->contenido_id)
                ->value('tipo') === 'serie';

        if (!$esSerie && $request->estado === 'viendo') {
            return back()
                ->withErrors(['estado' => 'El estado "Viendo" solo está disponible para series.'])
                ->withInput();
        }

        DB::table('biblioteca')->updateOrInsert(
            [
                'usuario_id' => auth()->id(),
                'contenido_id' => $request->contenido_id,
            ],
            [
                'estado' => $request->estado,
                'puntuacion' => $request->filled('puntuacion')
                    ? $request->puntuacion
                    : null,
                'fecha_inicio' => $request->filled('fecha_inicio')
                    ? $request->fecha_inicio
                    : null,
                'fecha_fin' => $request->filled('fecha_fin')
                    ? $request->fecha_fin
                    : null,
                'notas' => $request->input('notas'),
                'favorito' => (int) $request->boolean('favorito'),
            ]
        );

        return back()->with('success', 'Tu biblioteca se ha actualizado.');

    }
}
