{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Productos - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">
            <i class="bi bi-box-seam"></i> Productos
        </h2>
        <p class="text-muted">Gestiona el catálogo de productos de la tienda</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>
</div>

<!-- Filtros y búsqueda -->
<div class="card admin-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       placeholder="Buscar por nombre..."
                       value="{{ request('search') }}"
                       style="border-radius: 15px;">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select" style="border-radius: 15px;">
                    <option value="">Todas las categorías</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de productos -->
<div class="card admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th width="100">Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Franquicia</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="fw-bold">#{{ $product->id }}</td>
                        <td>
@if($product->image)
    @if(Str::startsWith($product->image, 'http'))
        <img src="{{ $product->image }}" 
             class="img-thumbnail" 
             style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;"
             alt="{{ $product->name }}">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" 
             class="img-thumbnail" 
             style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;"
             alt="{{ $product->name }}">
    @endif
@else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px; border-radius: 10px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($product->name, 40) }}</div>
                            @if($product->featured)
                                <span class="badge" style="background: var(--accent-color);">
                                    <i class="bi bi-star-fill"></i> Destacado
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $product->category->name }}</span>
                        </td>
                        <td>{{ $product->franchise->name }}</td>
                        <td class="fw-bold" style="color: var(--primary-color);">
                            {{ number_format($product->price, 2) }}€
                        </td>
                        <td>
                            @if($product->is_preorder)
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock"></i> Preventa
                                </span>
                            @else
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock }} unidades
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($product->stock > 0 || $product->is_preorder)
                                <span class="badge bg-success">Disponible</span>
                            @else
                                <span class="badge bg-danger">Agotado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   target="_blank"
                                   title="Ver en tienda">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-outline-primary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteProduct({{ $product->id }})"
                                        title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <form id="delete-form-{{ $product->id }}" 
                                  action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No se encontraron productos</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
                                <i class="bi bi-plus-circle"></i> Crear Primer Producto
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $products->firstItem() }} - {{ $products->lastItem() }} de {{ $products->total() }} productos
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function deleteProduct(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush