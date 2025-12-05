{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - OtakuShop')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Catálogo</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row">
    
        <!-- Imagen del Producto -->
    <div class="col-lg-5 mb-4">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                @if($product->image)
    @if(Str::startsWith($product->image, 'http'))
        <img src="{{ $product->image }}" 
             class="img-fluid w-100" 
             style="border-radius: 15px; max-height: 500px; object-fit: cover;"
             alt="{{ $product->name }}">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" 
             class="img-fluid w-100" 
             style="border-radius: 15px; max-height: 500px; object-fit: cover;"
             alt="{{ $product->name }}">
    @endif
@else
                    <div class="bg-light d-flex align-items-center justify-content-center flex-column" 
                        style="height: 500px; border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="bi bi-image text-white" style="font-size: 8rem; opacity: 0.5;"></i>
                        <p class="text-white mt-3 fs-5 fw-semibold">Sin imagen disponible</p>
                        <small class="text-white opacity-75">{{ $product->category->name }}</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Cambiar imagen principal al hacer clic en miniatura
    function changeMainImage(imageSrc, thumbnail) {
        const mainImage = document.querySelector('.main-product-image');
        mainImage.src = imageSrc;
    
        // Quitar clase active de todas las miniaturas
        document.querySelectorAll('.thumbnail-image').forEach(img => {
            img.style.border = '3px solid transparent';
            img.classList.remove('active');
        });
    
        // Añadir clase active a la miniatura clickeada
        thumbnail.style.border = '3px solid var(--primary-color)';
        thumbnail.classList.add('active');
    }

    // Efecto de zoom suave al pasar el mouse
    const mainImage = document.querySelector('.main-product-image');
    if (mainImage) {
        mainImage.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
        
            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;
        
            this.style.transformOrigin = `${xPercent}% ${yPercent}%`;
            this.style.transform = 'scale(1.5)';
        });
    
        mainImage.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
    </script>
    @endpush

    <!-- Información del Producto -->
    <div class="col-lg-7">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <!-- Badges -->
                <div class="mb-3">
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 0.5rem 1rem; border-radius: 15px; font-size: 0.9rem;">
                        {{ $product->category->name }}
                    </span>
                    <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; border-radius: 15px; font-size: 0.9rem;">
                        <i class="bi bi-star-fill text-warning"></i> {{ $product->franchise->name }}
                    </span>
                    @if($product->featured)
                        <span class="badge" style="background: var(--accent-color); padding: 0.5rem 1rem; border-radius: 15px; font-size: 0.9rem;">
                            <i class="bi bi-lightning-charge"></i> Destacado
                        </span>
                    @endif
                </div>

                <!-- Título -->
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

                <!-- Precio -->
                <div class="mb-4">
                    <span class="display-5 fw-bold" style="color: var(--primary-color);">
                        {{ number_format($product->price, 2) }}€
                    </span>
                </div>

                <!-- Stock / Disponibilidad -->
                <div class="mb-4">
                    @if($product->is_preorder)
                        <div class="alert" style="background: linear-gradient(135deg, #ffa502 0%, #ff6348 100%); color: white; border-radius: 15px;">
                            <i class="bi bi-clock-history"></i>
                            <strong>Preventa</strong> - Fecha estimada: {{ $product->release_date ? $product->release_date->format('d/m/Y') : 'Por confirmar' }}
                        </div>
                    @elseif($product->stock > 0)
                        <div class="alert alert-success" style="border-radius: 15px;">
                            <i class="bi bi-check-circle-fill"></i> 
                            <strong>En stock</strong> - {{ $product->stock }} unidades disponibles
                        </div>
                    @else
                        <div class="alert alert-danger" style="border-radius: 15px;">
                            <i class="bi bi-x-circle-fill"></i> 
                            <strong>Agotado</strong> - Actualmente no disponible
                        </div>
                    @endif
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Descripción</h5>
                    <p class="text-muted" style="line-height: 1.8;">{{ $product->description }}</p>
                </div>

                <!-- Información adicional -->
                <div class="mb-4 p-3" style="background: #f8f9fa; border-radius: 15px;">
                    <h6 class="fw-bold mb-3">Información del producto</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-tag text-primary"></i> 
                            <strong>Categoría:</strong> {{ $product->category->name }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-star text-warning"></i> 
                            <strong>Franquicia:</strong> {{ $product->franchise->name }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-box text-success"></i> 
                            <strong>Stock:</strong> {{ $product->stock }} unidades
                        </li>
                        @if($product->is_preorder && $product->release_date)
                        <li>
                            <i class="bi bi-calendar text-info"></i> 
                            <strong>Fecha de lanzamiento:</strong> {{ $product->release_date->format('d/m/Y') }}
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Formulario de compra -->
                @auth
                    @if($product->stock > 0 || $product->is_preorder)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Cantidad</label>
                                    <input type="number" 
                                           name="quantity" 
                                           class="form-control" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->is_preorder ? 10 : $product->stock }}"
                                           style="border-radius: 15px;">
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom btn-lg">
                                    <i class="bi bi-cart-plus"></i> Añadir al carrito
                                </button>
                            </div>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle"></i> Producto no disponible
                        </button>
                    @endif
                @else
                    <div class="alert alert-info" style="border-radius: 15px;">
                        <i class="bi bi-info-circle"></i> 
                        <a href="{{ route('login') }}">Inicia sesión</a> o 
                        <a href="{{ route('register') }}">regístrate</a> para comprar este producto.
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Productos Relacionados -->
@if($relatedProducts->count() > 0)
<section class="mt-5">
    <h3 class="fw-bold mb-4">Productos Relacionados</h3>
    <div class="row g-4">
        @foreach($relatedProducts as $related)
        <div class="col-md-6 col-lg-3">
            <div class="card product-card h-100">
                <div class="position-relative">
                    @if($related->image)
    @if(Str::startsWith($related->image, 'http'))
        <img src="{{ $related->image }}" 
             class="product-image" 
             alt="{{ $related->name }}">
    @else
        <img src="{{ asset('storage/' . $related->image) }}" 
             class="product-image" 
             alt="{{ $related->name }}">
    @endif
@else
                        <div class="product-image bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                </div>
                
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-2">{{ $related->name }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h6 mb-0 fw-bold" style="color: var(--primary-color);">
                            {{ number_format($related->price, 2) }}€
                        </span>
                        <a href="{{ route('products.show', $related) }}" 
                           class="btn btn-sm btn-primary-custom">
                            Ver
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection