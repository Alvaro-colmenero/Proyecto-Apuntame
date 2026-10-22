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

        return back()->with(
            'success',
            'Tu biblioteca se ha actualizado correctamente.'
        );
    }
}
