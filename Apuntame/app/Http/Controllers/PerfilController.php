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
                'biblioteca.fecha_fin'
            )
            ->get();

        return view('perfil.index', [
            'usuarioPerfil' => $usuarioPerfil,
            'contenidosPerfil' => $contenidosPerfil,
            'generosPerfil' => collect(),
            'generosEstadisticas' => collect(),
            'actividadPerfil' => collect(),
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

        return redirect()
            ->route('perfil.index')
            ->with('success', 'Tu perfil se ha actualizado correctamente.');
    }
}
