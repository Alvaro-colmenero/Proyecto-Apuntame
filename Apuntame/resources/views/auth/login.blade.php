@extends('layouts.app')

@section('title', 'Iniciar sesión | Apuntame')

@section('content')
    <div class="auth-page">
        <section class="auth-card">

            <div class="auth-brand">
                <div class="auth-icon">▶</div>
                <h1>¡Qué bueno verte!</h1>
                <p>Inicia sesión y continúa descubriendo tus películas y series favoritas.</p>
            </div>

            @if ($errors->any())
                <div class="auth-alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" autocomplete="email" required autofocus>
                    @error('email')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" placeholder="Introduce tu contraseña" autocomplete="current-password" required>
                    @error('password')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button class="auth-button" type="submit">
                    Iniciar sesión →
                </button>
            </form>

            <div class="auth-footer">
                ¿Todavía no tienes una cuenta?
                <a href="{{ route('registro') }}">Crear cuenta</a>
            </div>

            <div style="text-align: center;">
                <a class="auth-back" href="{{ route('contenidos.index') }}">
                    ← Volver al catálogo
                </a>
            </div>

        </section>
    </div>
@endsection
