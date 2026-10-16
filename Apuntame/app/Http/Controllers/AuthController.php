<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $usuario = Usuario::create([
            'nombre' => $datos['nombre'],
            'email' => mb_strtolower($datos['email']),
            'password' => Hash::make($datos['password']),
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('perfil.index');

    }

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credenciales['email'] = mb_strtolower($credenciales['email']);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect()->intended(route('perfil.index'));
        }

        return back()
            ->withErrors([
                'email' => 'El correo o la contraseña no son correctos.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('contenidos.index');
    }
}
