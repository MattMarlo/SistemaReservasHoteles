@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <h3 class="text-center mb-4"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h3>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Ingresa tu email">
        </div>
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
        </div>
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label for="remember_me" class="form-check-label">Recordarme</label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </button>
    </div>

    <div class="links">
        <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
    </div>
</form>
@endsection