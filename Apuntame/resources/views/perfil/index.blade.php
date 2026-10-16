@extends('layouts.app')

@section('title', 'Mi perfil | MiCineSeries')

@section('content')
@php
    $usuarioPerfil = $usuarioPerfil ?? auth()->user();
    $nombrePerfil = $usuarioPerfil->name ?? $usuarioPerfil->nombre ?? 'Invitado';
    $contenidosPerfil = collect($contenidosPerfil ?? []);
    $generosPerfil = collect($generosPerfil ?? []);
    $actividadPerfil = collect($actividadPerfil ?? []);
@endphp



<div class="perfil-pagina">
    <section class="perfil-portada">
        <div class="perfil-portada-fondo"></div>
        <div class="perfil-identidad">
            <div class="perfil-nombre">
                <span class="perfil-etiqueta">PERFIL</span>
                <h1>{{ $nombrePerfil }}</h1>
                <p>{{ $usuarioPerfil ? 'Tu espacio personal de cine y series' : 'Explora el catálogo y crea tu propia biblioteca' }}</p>
            </div>
            <a class="perfil-accion" href="{{ route('contenidos.index') }}">Explorar catálogo</a>
        </div>
    </section>
</div>

@endsection

