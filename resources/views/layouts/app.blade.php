<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OtakuShop - Tu tienda de anime favorita')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
    
        <!-- Fuente japonesa -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        :root {
            --primary-color: #ff6b9d;
            --secondary-color: #c44569;
            --accent-color: #ffa502;
            --dark-bg: #1e272e;
            --light-bg: #f8f9fa;
            --text-dark: #2d3436;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background: linear-gradient(135deg, #ffeef8 0%, #fff5e6 50%, #e8f4ff 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Partículas de fondo */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 157, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 165, 2, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Navbar Mejorada */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1.2rem 0;
            box-shadow: 0 8px 32px rgba(255, 107, 157, 0.4);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-family: 'Bebas Neue', cursive;
            font-weight: 700;
            font-size: 2.2rem;
            color: white !important;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            text-shadow: 0 0 20px rgba(255,255,255,0.8);
        }

        .navbar-brand i {
            animation: pulse 2s infinite;
            color: var(--accent-color);
            filter: drop-shadow(0 0 5px rgba(255,165,2,0.8));
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-link:hover::before {
            width: 70%;
        }

        .btn-cart {
            background: white;
            color: var(--primary-color);
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .btn-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: var(--primary-color);
        }

        .badge-cart {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            border-radius: 50%;
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            animation: bounce 2s infinite;
            box-shadow: 0 2px 10px rgba(255,165,2,0.5);
        }

        /* Dropdown mejorado */
        .dropdown-menu {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 0.5rem;
            margin-top: 0.5rem !important;
        }

        .dropdown-item {
            border-radius: 15px;
            padding: 0.7rem 1.2rem;
            transition: all 0.3s ease;
            margin: 0.2rem 0;
        }

        .dropdown-item:hover {
            background: var(--gradient-1);
            color: white;
            transform: translateX(5px);
        }

        /* Navbar Toggle mejorado */
        .navbar-toggler {
            border: 2px solid white;
            border-radius: 10px;
            padding: 0.5rem 0.8rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.3);
        }

        .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 3rem 0;
        }

        /* Cards de productos mejoradas */
        .product-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            position: relative;
        }

        .product-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,107,157,0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .product-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 20px 50px rgba(255, 107, 157, 0.3);
        }

        .product-card:hover::after {
            opacity: 1;
        }

        .product-image {
            height: 280px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.15);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(255,165,2,0.4);
            z-index: 2;
            animation: pulse 2s infinite;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,107,157,0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary-custom:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 107, 157, 0.5);
        }

        /* Footer mejorado */
        .footer {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #2d3436 100%);
            color: white;
            padding: 4rem 0 1.5rem;
            margin-top: 5rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--primary-color));
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--accent-color);
            font-size: 1.3rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-5px) rotate(360deg);
        }

        /* Alerts mejoradas */
        .alert {
            border-radius: 20px;
            border: none;
            padding: 1.2rem 1.8rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b9d 0%, #c44569 100%);
            color: white;
        }

        /* Hero Section mejorada */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 5rem 0;
            border-radius: 35px;
            margin-bottom: 3rem;
            box-shadow: 0 15px 50px rgba(255, 107, 157, 0.4);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.8rem;
            }
            
            .product-card:hover {
                transform: translateY(-8px);
            }
            
            .hero-section {
                padding: 3rem 0;
            }
        }

        /* Loading animation */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-charge-fill"></i> OtakuShop
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog') }}">
                            <i class="bi bi-grid"></i> Catálogo
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <!-- Botón Modo Oscuro -->
                    <li class="nav-item me-2 mb-2 mb-lg-0">
                        <button id="darkModeToggle" class="nav-link btn-cart" style="cursor: pointer; border: none; background: transparent;">
                            <i class="bi bi-moon-stars-fill"></i>
                        </button>
                    </li>
                    @auth
                        <li class="nav-item me-2 mb-2 mb-lg-0">
                            <a class="nav-link btn-cart position-relative" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i> Carrito
                                @if(auth()->user()->cartItems->count() > 0)
                                    <span class="badge-cart">{{ auth()->user()->cartItems->sum('quantity') }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag-check"></i> Mis Pedidos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person"></i> Mi Perfil
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2"></i> Panel Admin
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @else
                            <li class="nav-item me-2 mb-2 mb-lg-0">
                                <a class="nav-link" href="{{ route('login') }}" style="transition: all 0.3s ease;">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                </a>
                            </li>
                            <li class="nav-item mb-2 mb-lg-0">
                                <a class="btn btn-light fw-semibold px-4" href="{{ route('register') }}" style="border-radius: 50px; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    <i class="bi bi-person-plus-fill"></i> Registrarse
                                </a>
                            </li>
                        @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Alertas -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>¡Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-lightning-charge-fill"></i> OtakuShop</h5>
                    <p class="text-muted">Tu tienda especializada en productos de anime y cultura japonesa. Los mejores artículos para verdaderos otakus.</p>
                    <div class="social-links d-flex gap-3 mt-3">
                        <a href="#"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#"><i class="bi bi-twitter-x fs-4"></i></a>
                        <a href="#"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#"><i class="bi bi-youtube fs-4"></i></a>
                        <a href="#"><i class="bi bi-tiktok fs-4"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="mb-3">Enlaces Rápidos</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> Inicio</a></li>
                        <li class="mb-2"><a href="{{ route('catalog') }}"><i class="bi bi-chevron-right"></i> Catálogo</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Sobre Nosotros</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="mb-3">Categorías</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Figuras</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Manga</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Ropa</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Cosplay</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">Ayuda</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> FAQ</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Envíos</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Devoluciones</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right"></i> Términos</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="text-center text-muted">
                <p class="mb-2">&copy; 2025 OtakuShop. Todos los derechos reservados.</p>
                <p class="small mb-0">
                    <i class="bi bi-code-slash"></i> Proyecto Final - Antonio Ciobanu Amaya | IES Barajas
                </p>
            </div>
        </div>
    </footer>

     <!-- Caracteres japoneses decorativos de fondo -->
    <div class="japanese-bg-text" style="position: fixed; top: 15%; right: -50px; font-size: 10rem; opacity: 0.03; z-index: 0; font-family: 'Noto Sans JP', sans-serif; pointer-events: none; color: var(--primary-color); transform: rotate(15deg);">
        アニメ
    </div>
    <div class="japanese-bg-text" style="position: fixed; bottom: 15%; left: -30px; font-size: 8rem; opacity: 0.03; z-index: 0; font-family: 'Noto Sans JP', sans-serif; pointer-events: none; color: var(--accent-color); transform: rotate(-10deg);">
        オタク
    </div>
    <div class="japanese-bg-text" style="position: fixed; top: 50%; left: 50%; font-size: 6rem; opacity: 0.02; z-index: 0; font-family: 'Noto Sans JP', sans-serif; pointer-events: none; color: var(--secondary-color); transform: translate(-50%, -50%) rotate(-5deg);">
        ショップ
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript Personalizado -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>