{{-- resources/views/partials/product-card.blade.php --}}
<div class="col-md-6 col-lg-4">
    <div class="card product-card h-100">
        <div class="position-relative overflow-hidden" style="height: 280px;">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="product-image lazy-image" 
                     data-src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     loading="lazy"
                     onerror="this.src='https://via.placeholder.com/400x280/667eea/ffffff?text={{ urlencode($product->category->name) }}'"
                     onclick="showImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
            @else
                <div class="product-image-placeholder d-flex align-items-center justify-content-center flex-column" 
                     style="background: linear-gradient(135deg, {{ ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a'][rand(0, 4)] }} 0%, {{ ['#764ba2', '#f5576c', '#00f2fe', '#38f9d7', '#fee140'][rand(0, 4)] }} 100%);">
                    <i class="bi bi-image" style="font-size: 4rem; color: rgba(255,255,255,0.5);"></i>
                    <p class="text-white mt-2 mb-0 fw-semibold">{{ $product->category->name }}</p>
                    <small class="text-white opacity-75">Sin imagen</small>
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
            @elseif($product->stock == 0)
                <span class="product-badge bg-secondary">
                    Agotado
                </span>
            @endif

            <!-- Botón de zoom en hover -->
            @if($product->image)
            <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                 style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease;"
                 onclick="showImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
                <i class="bi bi-zoom-in text-white" style="font-size: 3rem; cursor: pointer;"></i>
            </div>
            @endif
        </div>
        
        <div class="card-body d-flex flex-column">
            <div class="mb-2">
                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                    {{ $product->category->name }}
                </span>
                <span class="badge bg-light text-dark" style="border-radius: 10px;">
                    <i class="bi bi-star text-warning"></i> {{ $product->franchise->name }}
                </span>
            </div>
            
            <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
            <p class="text-muted small mb-3 flex-grow-1" style="height: 40px; overflow: hidden;">
                {{ Str::limit($product->description, 70) }}
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

<style>
.product-card:hover .image-overlay {
    opacity: 1 !important;
}

.lazy-image {
    opacity: 0;
    transition: opacity 0.5s ease;
}

.lazy-image.loaded {
    opacity: 1;
}
</style>