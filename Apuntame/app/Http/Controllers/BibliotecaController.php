<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BibliotecaController extends Controller
{
    public function guardar(Request $request)
    {
        // Validar todos los datos del formulario
        $datos = $request->validate([
            'contenido_id' => ['required', 'integer', 'exists:contenidos,id',],
            'estado' => ['required', 'in:pendiente,viendo,vista,pausada,abandonada',],
            'puntuacion' => ['nullable', 'numeric', 'min:0', 'max:10',],
            'fecha_inicio' => ['nullable', 'date',],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio',],
            'notas' => ['nullable', 'string', 'max:5000',],
            'favorito' => ['required', 'boolean',],
        ]);

        // Obtener el contenido
        $contenido = DB::table('contenidos')
            ->where('id', $datos['contenido_id'])
            ->first();

        // Las películas no pueden estar en estado "viendo"
        if ($contenido->tipo === 'pelicula' && $datos['estado'] === 'viendo') {
            return back()
                ->withErrors(['estado' => 'Una película no puede tener el estado Viendo.',])
                ->withInput();
        }

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

        return back()->with('success', 'Tu biblioteca se ha actualizado.');
    }
}
