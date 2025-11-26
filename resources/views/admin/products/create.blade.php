{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Crear Producto - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Productos</a></li>
                <li class="breadcrumb-item active">Crear Producto</li>
            </ol>
        </nav>
        <h2 class="fw-bold">
            <i class="bi bi-plus-circle"></i> Crear Nuevo Producto
        </h2>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" data-validate="true">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Información básica -->
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Información Básica</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}"
                               placeholder="Ej: Figura Luffy Gear 5"
                               required
                               style="border-radius: 15px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="6"
                                  placeholder="Describe el producto detalladamente..."
                                  required
                                  style="border-radius: 15px;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                            <select name="category_id" 
                                    class="form-select @error('category_id') is-invalid @enderror" 
                                    required
                                    style="border-radius: 15px;">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Franquicia <span class="text-danger">*</span></label>
                            <select name="franchise_id" 
                                    class="form-select @error('franchise_id') is-invalid @enderror" 
                                    required
                                    style="border-radius: 15px;">
                                <option value="">Selecciona una franquicia</option>
                                @foreach($franchises as $franchise)
                                    <option value="{{ $franchise->id }}" {{ old('franchise_id') == $franchise->id ? 'selected' : '' }}>
                                        {{ $franchise->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('franchise_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Precios e inventario -->
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Precio e Inventario</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Precio (€) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required
                                       style="border-radius: 15px 0 0 15px;">
                                <span class="input-group-text" style="border-radius: 0 15px 15px 0;">€</span>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stock" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', 0) }}"
                                   min="0"
                                   placeholder="0"
                                   required
                                   style="border-radius: 15px;">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_preorder" 
                                   id="is_preorder"
                                   value="1"
                                   {{ old('is_preorder') ? 'checked' : '' }}
                                   onchange="togglePreorder()">
                            <label class="form-check-label fw-semibold" for="is_preorder">
                                Este producto es una preventa
                            </label>
                        </div>
                    </div>

                    <div id="preorder-date" style="display: none;">
                        <label class="form-label fw-semibold">Fecha de Lanzamiento</label>
                        <input type="date" 
                               name="release_date" 
                               class="form-control @error('release_date') is-invalid @enderror" 
                               value="{{ old('release_date') }}"
                               style="border-radius: 15px;">
                        @error('release_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Imagen -->
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Imagen del Producto</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subir Imagen</label>
                        <input type="file" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(event)"
                               style="border-radius: 15px;">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Formatos: JPG, PNG, GIF. Máximo: 2MB</small>
                    </div>

                    <div id="image-preview" class="mt-3 text-center" style="display: none;">
                        <img id="preview" 
                             src="" 
                             class="img-fluid" 
                             style="max-height: 300px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>

            <!-- Configuración adicional -->
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Configuración</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="featured" 
                               id="featured"
                               value="1"
                               {{ old('featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            <i class="bi bi-star-fill text-warning"></i> Producto destacado
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-check-circle"></i> Crear Producto
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        const container = document.getElementById('image-preview');
        preview.src = reader.result;
        container.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function togglePreorder() {
    const isPreorder = document.getElementById('is_preorder').checked;
    const preorderDate = document.getElementById('preorder-date');
    preorderDate.style.display = isPreorder ? 'block' : 'none';
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    togglePreorder();
});
</script>
@endpush