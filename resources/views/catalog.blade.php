{{-- resources/views/catalog.blade.php --}}
@extends('layouts.app')

@section('title', 'Catálogo - OtakuShop')

@section('content')
<div class="row">
    <!-- Sidebar de Filtros -->
    <div class="col-lg-3 mb-4">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-funnel"></i> Filtros
                </h5>

                <form action="{{ route('catalog') }}" method="GET">
                    <!-- Búsqueda -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Buscar</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Nombre del producto..."
                                   value="{{ request('search') }}"
                                   style="border-radius: 15px 0 0 15px;">
                            <button class="btn btn-primary-custom" type="submit" style="border-radius: 0 15px 15px 0;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filtro por Categoría -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Categoría</label>
                        <select name="category" class="form-select" style="border-radius: 15px;">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Franquicia -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Franquicia</label>
                        <select name="franchise" class="form-select" style="border-radius: 15px;">
                            <option value="">Todas las franquicias</option>
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->id }}" 
                                        {{ request('franchise') == $franchise->id ? 'selected' : '' }}>
                                    {{ $franchise->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-funnel"></i> Aplicar Filtros
                        </button>
                        <a href="{{ route('catalog') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de Productos -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Catálogo de Productos</h2>
                <p class="text-muted mb-0">{{ $products->total() }} productos encontrados</p>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
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
                                    {{ $product->franchise->name }}
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
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-search" style="font-size: 5rem; color: var(--primary-color);"></i>
                <h4 class="mt-3">No se encontraron productos</h4>
                <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary-custom mt-3">
                    Ver todos los productos
                </a>
            </div>
        @endif
    </div>
</div>
@endsection