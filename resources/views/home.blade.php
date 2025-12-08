{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'OtakuShop - Inicio')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center position-relative">
    <div class="position-relative" style="z-index: 2;">
        <h1 class="display-3 fw-bold mb-3" style="font-family: 'Bebas Neue', cursive; letter-spacing: 3px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
            ¡Bienvenido a OtakuShop!
        </h1>
        <p class="lead mb-4 fs-4">
            <i class="bi bi-star-fill text-warning"></i>
            Tu tienda especializada en anime, manga y cultura japonesa
            <i class="bi bi-star-fill text-warning"></i>
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('catalog') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                <i class="bi bi-shop"></i> Explorar Catálogo
            </a>
            <a href="{{ route('catalog', ['featured' => true]) }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                <i class="bi bi-lightning-charge"></i> Productos Destacados
            </a>
        </div>
    </div>
</div>

<!-- Características destacadas -->
<section class="mb-5">
    <div class="row g-4">
        <div class="col-md-3 col-6">
            <div class="text-center p-4 h-100" style="background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(102, 126, 234, 0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                <div class="mb-3" style="font-size: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-truck"></i>
                </div>
                <h6 class="fw-bold">Envío Gratis</h6>
                <p class="text-muted small mb-0">En todos los pedidos</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-4 h-100" style="background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(240, 147, 251, 0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                <div class="mb-3" style="font-size: 3rem; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6 class="fw-bold">Pago Seguro</h6>
                <p class="text-muted small mb-0">100% protegido</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-4 h-100" style="background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(79, 172, 254, 0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                <div class="mb-3" style="font-size: 3rem; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h6 class="fw-bold">Devoluciones</h6>
                <p class="text-muted small mb-0">30 días garantía</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-4 h-100" style="background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(67, 233, 123, 0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                <div class="mb-3" style="font-size: 3rem; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-headset"></i>
                </div>
                <h6 class="fw-bold">Soporte 24/7</h6>
                <p class="text-muted small mb-0">Siempre disponibles</p>
            </div>
        </div>
    </div>
</section>

<!-- Categorías -->
<section class="mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2" style="font-size: 2.5rem;">
            <i class="bi bi-grid-3x3-gap text-primary"></i> Compra por Categoría
        </h2>
        <p class="text-muted">Encuentra exactamente lo que buscas</p>
    </div>
    
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('catalog', ['category' => $category->id]) }}" class="text-decoration-none">
                <div class="card product-card h-100 text-center p-4" style="cursor: pointer;">
                    <div class="mb-3" style="font-size: 4rem;">
                        @switch($category->name)
                            @case('Figuras')
                                <i class="bi bi-trophy" style="background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                @break
                            @case('Manga')
                                <i class="bi bi-book" style="background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                @break
                            @case('Ropa')
                                <i class="bi bi-bag" style="background: linear-gradient(135deg, #0d6efd 0%, #6ea8fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                @break
                            @case('Cosplay')
                                <i class="bi bi-mask" style="background: linear-gradient(135deg, #0dcaf0 0%, #6edff6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                @break
                            @default
                                <i class="bi bi-star" style="background: linear-gradient(135deg, #198754 0%, #75b798 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        @endswitch
                    </div>
                    <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                    <p class="text-muted small mb-3">{{ $category->description }}</p>
                    <div class="mt-auto">
                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 0.5rem 1rem; border-radius: 20px;">
                            Ver productos <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

<!-- Productos Destacados -->
<section class="mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2" style="font-size: 2.5rem;">
            <i class="bi bi-star-fill text-warning"></i> Productos Destacados
        </h2>
        <p class="text-muted">Los favoritos de nuestra comunidad otaku</p>
    </div>
    
    @if($featuredProducts->count() > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative overflow-hidden" style="height: 280px;">
                        @if($product->image)
                            <img src="{{ $product->getImageUrl() }}"
                                 class="product-image" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        
                        @if($product->is_preorder)
                            <span class="product-badge">
                                <i class="bi bi-clock"></i> Preventa
                            </span>
                        @elseif($product->stock < 5 && $product->stock > 0)
                            <span class="product-badge bg-danger">
                                ¡Solo {{ $product->stock }}!
                            </span>
                        @elseif($product->featured)
                            <span class="product-badge">
                                <i class="bi bi-star-fill"></i> Top
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge mb-1" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                                {{ $product->category->name }}
                            </span>
                            <span class="badge bg-light text-dark" style="border-radius: 10px;">
                                <i class="bi bi-star text-warning"></i> {{ $product->franchise->name }}
                            </span>
                        </div>
                        
                        <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
                        <p class="text-muted small mb-3 flex-grow-1" style="height: 40px; overflow: hidden;">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="h5 mb-0 fw-bold" style="color: var(--primary-color);">
                                {{ number_format($product->price, 2) }}€
                            </span>
                            <a href="{{ route('products.show', $product) }}" 
                               class="btn btn-sm btn-primary-custom">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('catalog') }}" class="btn btn-primary-custom btn-lg">
                Ver Todo el Catálogo <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="alert alert-info text-center" style="border-radius: 20px;">
            <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
            <p class="mb-0">Aún no hay productos destacados disponibles.</p>
        </div>
    @endif
</section>

<!-- Franquicias Populares -->
<section class="mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2" style="font-size: 2.5rem;">
            <i class="bi bi-fire text-danger"></i> Franquicias Populares
        </h2>
        <p class="text-muted">Tus animes favoritos en un solo lugar</p>
    </div>
    
    <div class="row g-3">
        @foreach($franchises->take(8) as $index => $franchise)
        <div class="col-6 col-md-3">
            <a href="{{ route('catalog', ['franchise' => $franchise->id]) }}" 
               class="btn w-100 py-3 position-relative overflow-hidden" 
               style="border-radius: 20px; font-weight: 600; border: 2px solid; 
                      @php
                        $colors = [
                            'border-color: #667eea; color: #667eea;',
                            'border-color: #f093fb; color: #f093fb;',
                            'border-color: #4facfe; color: #4facfe;',
                            'border-color: #43e97b; color: #43e97b;',
                            'border-color: #fa709a; color: #fa709a;',
                            'border-color: #ffd700; color: #ffd700;',
                            'border-color: #ff6b6b; color: #ff6b6b;',
                            'border-color: #6ea8fe; color: #6ea8fe;'
                        ];
                        echo $colors[$index % 8];
                      @endphp">
                {{ $franchise->name }}
            </a>
        </div>
        @endforeach
    </div>
</section>

<!-- Banner promocional -->
<section class="mt-5">
    <div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 30px; padding: 4rem 2rem; box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-8 text-white">
                <h2 class="fw-bold mb-3" style="font-size: 2.5rem;">¿Listo para empezar tu colección?</h2>
                <p class="fs-5 mb-4">Únete a miles de otakus que ya confían en nosotros</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5" style="border-radius: 50px; font-weight: 600;">
                        <i class="bi bi-person-plus"></i> Crear Cuenta Gratis
                    </a>
                @else
                    <a href="{{ route('catalog') }}" class="btn btn-light btn-lg px-5" style="border-radius: 50px; font-weight: 600;">
                        <i class="bi bi-shop"></i> Empezar a Comprar
                    </a>
                @endguest
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="bi bi-gift" style="font-size: 8rem; color: rgba(255,255,255,0.3);"></i>
            </div>
        </div>
        
        <!-- Círculos decorativos -->
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Efecto de texto con gradiente animado */
    .gradient-text {
        background: linear-gradient(45deg, #ff6b9d, #c44569, #ffa502, #ff6b9d);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient-animation 3s ease infinite;
    }
    
    @keyframes gradient-animation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Estrellas parpadeantes */
    .star {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 0 3px white;
        animation: twinkle 2s ease-in-out infinite;
    }
    
    @keyframes twinkle {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }
    
    /* Efecto kawaii en imágenes */
    .kawaii-shake:hover {
        animation: kawaii-shake 0.5s ease-in-out;
    }
    
    @keyframes kawaii-shake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-5deg); }
        75% { transform: rotate(5deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada escalonada para productos
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in-up');
            }, index * 100);
        });
        
        // Efecto parallax suave en el hero
        window.addEventListener('scroll', function() {
            const hero = document.querySelector('.hero-section');
            if (hero) {
                const scrolled = window.pageYOffset;
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    });
</script>
@endpush