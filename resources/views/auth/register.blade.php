@extends('layouts.app')

@section('title', 'Registrarse - OtakuShop')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card" style="border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: none; overflow: hidden;">
                    <div class="row g-0">
                        <!-- Lado izquierdo - Imagen/Diseño -->
                        <div class="col-md-5 d-none d-md-block" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); position: relative;">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 p-5 text-white">
                                <div class="mb-4">
                                    <i class="bi bi-person-plus-fill" style="font-size: 5rem;"></i>
                                </div>
                                <h2 class="fw-bold mb-3 text-center" style="font-family: 'Bebas Neue', cursive; font-size: 2.5rem;">
                                    Únete a OtakuShop
                                </h2>
                                <p class="text-center mb-4">Crea tu cuenta y disfruta de beneficios exclusivos</p>
                                
                                <!-- Beneficios -->
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-gift-fill me-2 fs-4"></i>
                                        <span>Descuentos especiales</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-bell-fill me-2 fs-4"></i>
                                        <span>Notificaciones de preventas</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-heart-fill me-2 fs-4"></i>
                                        <span>Lista de deseos</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-star-fill me-2 fs-4"></i>
                                        <span>Acceso anticipado</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lado derecho - Formulario -->
                        <div class="col-md-7">
                            <div class="card-body p-5">
                                <!-- Logo móvil -->
                                <div class="text-center mb-4 d-md-none">
                                    <i class="bi bi-lightning-charge-fill" style="font-size: 3rem; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                    <h3 class="fw-bold mt-2">OtakuShop</h3>
                                </div>

                                <h3 class="fw-bold mb-2">Crear cuenta</h3>
                                <p class="text-muted mb-4">Únete a nuestra comunidad otaku</p>

                                <!-- Botón Google -->
                                <a href="{{ route('auth.google') }}" class="btn w-100 mb-4 d-flex align-items-center justify-content-center" style="background: white; border: 2px solid #e0e0e0; border-radius: 15px; padding: 0.8rem; transition: all 0.3s ease;">
                                    <svg width="20" height="20" viewBox="0 0 20 20" class="me-2">
                                        <path d="M19.6 10.23c0-.82-.1-1.42-.25-2.05H10v3.72h5.5c-.15.96-.74 2.31-2.04 3.22v2.45h3.16c1.89-1.73 2.98-4.3 2.98-7.34z" fill="#4285F4"/>
                                        <path d="M13.46 15.13c-.83.59-1.96 1-3.46 1-2.64 0-4.88-1.74-5.68-4.15H1.07v2.52C2.72 17.75 6.09 20 10 20c2.7 0 4.96-.89 6.62-2.42l-3.16-2.45z" fill="#34A853"/>
                                        <path d="M3.99 10c0-.69.12-1.35.32-1.97V5.51H1.07A9.973 9.973 0 000 10c0 1.61.39 3.14 1.07 4.49l3.24-2.52c-.2-.62-.32-1.28-.32-1.97z" fill="#FBBC05"/>
                                        <path d="M10 3.88c1.88 0 3.13.81 3.85 1.48l2.84-2.76C14.96.99 12.7 0 10 0 6.09 0 2.72 2.25 1.07 5.51l3.24 2.52C5.12 5.62 7.36 3.88 10 3.88z" fill="#EA4335"/>
                                    </svg>
                                    <span class="fw-semibold">Registrarse con Google</span>
                                </a>

                                <div class="position-relative mb-4">
                                    <hr>
                                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">O regístrate con email</span>
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

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold">Nombre completo</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa; border-right: none;">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input id="name" 
                                                   type="text" 
                                                   name="name" 
                                                   class="form-control" 
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autofocus 
                                                   placeholder="Tu nombre"
                                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                                        </div>
                                    </div>

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
                                                   class="form-control" 
                                                   value="{{ old('email') }}" 
                                                   required 
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
                                                   placeholder="Mínimo 8 caracteres"
                                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa; border-right: none;">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input id="password_confirmation" 
                                                   type="password" 
                                                   name="password_confirmation" 
                                                   class="form-control" 
                                                   required 
                                                   placeholder="Repite tu contraseña"
                                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary-custom w-100 mb-3" style="padding: 0.8rem; font-size: 1.1rem;">
                                        <i class="bi bi-person-plus-fill"></i> Crear Cuenta
                                    </button>

                                    <!-- Login Link -->
                                    <p class="text-center mb-0">
                                        ¿Ya tienes cuenta? 
                                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-color);">
                                            Inicia sesión aquí
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