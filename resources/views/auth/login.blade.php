@extends('layouts.app')

@section('title', 'Iniciar Sesión - OtakuShop')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card" style="border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: none; overflow: hidden;">
                    <div class="row g-0">
                        <!-- Lado izquierdo - Imagen/Diseño -->
                        <div class="col-md-5 d-none d-md-block" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); position: relative;">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 p-5 text-white">
                                <div class="mb-4">
                                    <i class="bi bi-lightning-charge-fill" style="font-size: 5rem; animation: pulse 2s infinite;"></i>
                                </div>
                                <h2 class="fw-bold mb-3 text-center" style="font-family: 'Bebas Neue', cursive; font-size: 2.5rem;">
                                    OtakuShop
                                </h2>
                                <p class="text-center mb-4">Tu tienda de anime y manga favorita</p>
                                
                                <!-- Características -->
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                        <span>Productos exclusivos</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                        <span>Envío gratis</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                        <span>Preventas disponibles</span>
                                    </div>
                                </div>
                                
                                <!-- Decoración -->
                                <div style="position: absolute; bottom: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                                <div style="position: absolute; top: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
                            </div>
                        </div>

                        <!-- Lado derecho - Formulario -->
                        <div class="col-md-7">
                            <div class="card-body p-5">
                                <!-- Logo móvil -->
                                <div class="text-center mb-4 d-md-none">
                                    <i class="bi bi-lightning-charge-fill" style="font-size: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                    <h3 class="fw-bold mt-2">OtakuShop</h3>
                                </div>

                                <h3 class="fw-bold mb-2">¡Bienvenido de vuelta!</h3>
                                <p class="text-muted mb-4">Inicia sesión para continuar</p>

                                <!-- Botón Google -->
                                <a href="{{ route('auth.google') }}" class="btn w-100 mb-4 d-flex align-items-center justify-content-center" style="background: white; border: 2px solid #e0e0e0; border-radius: 15px; padding: 0.8rem; transition: all 0.3s ease;">
                                    <svg width="20" height="20" viewBox="0 0 20 20" class="me-2">
                                        <path d="M19.6 10.23c0-.82-.1-1.42-.25-2.05H10v3.72h5.5c-.15.96-.74 2.31-2.04 3.22v2.45h3.16c1.89-1.73 2.98-4.3 2.98-7.34z" fill="#4285F4"/>
                                        <path d="M13.46 15.13c-.83.59-1.96 1-3.46 1-2.64 0-4.88-1.74-5.68-4.15H1.07v2.52C2.72 17.75 6.09 20 10 20c2.7 0 4.96-.89 6.62-2.42l-3.16-2.45z" fill="#34A853"/>
                                        <path d="M3.99 10c0-.69.12-1.35.32-1.97V5.51H1.07A9.973 9.973 0 000 10c0 1.61.39 3.14 1.07 4.49l3.24-2.52c-.2-.62-.32-1.28-.32-1.97z" fill="#FBBC05"/>
                                        <path d="M10 3.88c1.88 0 3.13.81 3.85 1.48l2.84-2.76C14.96.99 12.7 0 10 0 6.09 0 2.72 2.25 1.07 5.51l3.24 2.52C5.12 5.62 7.36 3.88 10 3.88z" fill="#EA4335"/>
                                    </svg>
                                    <span class="fw-semibold">Continuar con Google</span>
                                </a>

                                <div class="position-relative mb-4">
                                    <hr>
                                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">O continúa con email</span>
                                </div>

                                <!-- Errores -->
                                @if ($errors->any())
                                    <div class="alert alert-danger" style="border-radius: 15px;">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa; border-right: none;">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input id="email" 
                                                   type="email" 
                                                   name="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   value="{{ old('email') }}" 
                                                   required 
                                                   autofocus 
                                                   placeholder="tu@email.com"
                                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa; border-right: none;">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input id="password" 
                                                   type="password" 
                                                   name="password" 
                                                   class="form-control" 
                                                   required 
                                                   placeholder="••••••••"
                                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                                        </div>
                                    </div>

                                    <!-- Remember Me & Forgot Password -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Recuérdame
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                                ¿Olvidaste tu contraseña?
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary-custom w-100 mb-3" style="padding: 0.8rem; font-size: 1.1rem;">
                                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                    </button>

                                    <!-- Register Link -->
                                    <p class="text-center mb-0">
                                        ¿No tienes cuenta? 
                                        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-color);">
                                            Regístrate aquí
                                        </a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Link a Home -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none fw-semibold">
                        <i class="bi bi-arrow-left"></i> Volver a la tienda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
