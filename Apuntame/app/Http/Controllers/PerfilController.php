<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Genero;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index', [

        ]);
    }
}
