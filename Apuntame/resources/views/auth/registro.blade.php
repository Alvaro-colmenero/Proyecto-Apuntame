@extends('layouts.app')

@section('title', 'Crear cuenta | Apuntame')

@section('content')
    <div class="auth-page">
        <section class="auth-card">

            <div class="auth-brand">
                <div class="auth-icon">✦</div>
                <h1>Únete a Apuntame</h1>
                <p>Crea tu cuenta y ten tus películas y series favoritas siempre a mano.</p>
            </div>

            @if ($errors->any())
                <div class="auth-alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('registro') }}">
                @csrf

                <div class="auth-field">
                    <label for="nombre">Nombre completo</label>
                    <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" autocomplete="name" maxlength="100" required>
                    @error('nombre')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" autocomplete="email" required>
                    @error('email')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password" minlength="8" required>
                    @error('password')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repite tu contraseña" autocomplete="new-password" minlength="8" required>
                </div>

                <button class="auth-button" type="submit">Crear mi cuenta →</button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}">Inicia sesión</a>
            </div>

            <div style="text-align: center;">
                <a class="auth-back" href="{{ route('contenidos.index') }}">
                    ← Volver al catálogo
                </a>
            </div>

        </section>
    </div>
@endsection
