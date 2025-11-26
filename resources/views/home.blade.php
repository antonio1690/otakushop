{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'OtakuShop - Inicio')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center">
    <h1 class="display-4 fw-bold mb-3">
        ¡Bienvenido a OtakuShop!
    </h1>
    <p class="lead mb-4">
        Tu tienda especializada en anime, manga y cultura japonesa
    </p>
    <a href="{{ route('catalog') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
        <i class="bi bi-shop"></i> Explorar Catálogo
    </a>
</div>

<!-- Categorías -->
<section class="mb-5">
    <h2 class="text-center mb-4 fw-bold">Compra por Categoría</h2>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('catalog', ['category' => $category->id]) }}" class="text-decoration-none">
                <div class="card product-card h-100 text-center p-4">
                    <div class="mb-3" style="font-size: 3rem;">
                        @switch($category->name)
                            @case('Figuras')
                                <i class="bi bi-trophy text-warning"></i>
                                @break
                            @case('Manga')
                                <i class="bi bi-book text-danger"></i>
                                @break
                            @case('Ropa')
                                <i class="bi bi-bag text-primary"></i>
                                @break
                            @case('Cosplay')
                                <i class="bi bi-mask text-info"></i>
                                @break
                            @default
                                <i class="bi bi-star text-success"></i>
                        @endswitch
                    </div>
                    <h5 class="fw-bold">{{ $category->name }}</h5>
                    <p class="text-muted small">{{ $category->description }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

<!-- Productos Destacados -->
<section>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Productos Destacados</h2>
        <a href="{{ route('catalog') }}" class="text-decoration-none">
            Ver todos <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    
    @if($featuredProducts->count() > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
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
                        @elseif($product->stock < 5)
                            <span class="product-badge bg-danger">
                                ¡Últimas unidades!
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <div class="text-muted small mb-1">
                            <i class="bi bi-tag"></i> {{ $product->franchise->name }}
                        </div>
                        <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
                        <p class="text-muted small mb-3" style="height: 40px; overflow: hidden;">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 fw-bold" style="color: var(--primary-color);">
                                {{ number_format($product->price, 2) }}€
                            </span>
                            <a href="{{ route('products.show', $product) }}" 
                               class="btn btn-sm btn-primary-custom">
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Aún no hay productos destacados disponibles.
        </div>
    @endif
</section>

<!-- Franquicias Populares -->
<section class="mt-5">
    <h2 class="text-center mb-4 fw-bold">Franquicias Populares</h2>
    <div class="row g-3">
        @foreach($franchises->take(8) as $franchise)
        <div class="col-6 col-md-3">
            <a href="{{ route('catalog', ['franchise' => $franchise->id]) }}" 
               class="btn btn-outline-primary w-100 py-3" 
               style="border-radius: 15px; font-weight: 600;">
                {{ $franchise->name }}
            </a>
        </div>
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Contador animado para estadísticas (si agregas stats en el futuro)
    function animateValue(element, start, end, duration) {
        let current = start;
        const range = end - start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));
        
        const timer = setInterval(function() {
            current += increment;
            element.textContent = current;
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Filtro rápido de productos
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.product-card');
        
        // Añadir animación de entrada escalonada
        productCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in-up');
            }, index * 100);
        });
    });
</script>
@endpush