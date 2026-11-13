<!--
+----------------------------------------------------------+
|¿Qué es esto?                                        _ ▄ x|
+----------------------------------------------------------+
|Es el código encargado de la página de inicio de registro.|
+----------------------------------------------------------+
-->
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
            <!--Si no hay errores se ejecuta el bloque if-->
            @if ($errors->any())
                <div class="auth-alert">
                    <!--Por todos los mensajes de error, se introducen dentro de divs-->
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <!--Formulario que tiene el metodo post, que la acción va destinada al helpers.php-->
            <form class="auth-form" method="POST" action="{{ route('login') }}">
                <!--
                +-----------------------------------------------------------------------------------+
                |Qué hace csrf                                                                 _ ▄ x|
                +-----------------------------------------------------------------------------------+
                |Se utiliza para los formularios, evita que sitios web maliciosos realicen acciones |
                |no deseadas al nombre de un usuario autentificado.                                 |
                +-----------------------------------------------------------------------------------+
                -->
                @csrf

                <div class="auth-field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" autocomplete="email" required autofocus>
                    <!--Si el campo email da error, entonces manda el mensaje-->
                    @error('email')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" placeholder="Introduce tu contraseña" autocomplete="current-password" required>
                    <!--Si la contraseña, entonces manda el mensaje-->
                    @error('password')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button class="auth-button" type="submit">Iniciar sesión →</button>
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
