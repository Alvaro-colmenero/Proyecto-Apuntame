
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContenidoController;

// CONTENIDOS
Route::get('/', [ContenidoController::class, 'index'])->name('contenidos.index');
Route::get('/contenidos/{contenido}', [ContenidoController::class, 'show'])->name('contenidos.show');

// REGISTRO
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware('guest')->group(function () {Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.guardar');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.autenticar');
});

// PERFIL
Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
});
