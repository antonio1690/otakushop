{{-- resources/views/partials/product-card.blade.php --}}
<div class="col-md-6 col-lg-4">
    <div class="card product-card h-100">
        <div class="position-relative overflow-hidden" style="height: 280px;">
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
            @elseif($product->stock < 5 && $product->stock > 0)
                <span class="product-badge bg-danger">
                    ¡Solo {{ $product->stock }}!
                </span>
            @elseif($product->stock == 0)
                <span class="product-badge bg-secondary">
                    Agotado
                </span>
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