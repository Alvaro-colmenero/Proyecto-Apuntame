
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContenidoController;

Route::get('/', [ContenidoController::class, 'index'])->name('contenidos.index');
Route::get('/contenidos/{contenido}', [ContenidoController::class, 'show'])->name('contenidos.show');
