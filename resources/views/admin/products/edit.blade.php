{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Editar Producto - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Productos</a></li>
                <li class="breadcrumb-item active">Editar: {{ $product->name }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold">
            <i class="bi bi-pencil"></i> Editar Producto
        </h2>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Información Básica</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $product->name) }}"
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
                                  required
                                  style="border-radius: 15px;">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required style="border-radius: 15px;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Franquicia <span class="text-danger">*</span></label>
                            <select name="franchise_id" class="form-select" required style="border-radius: 15px;">
                                @foreach($franchises as $franchise)
                                    <option value="{{ $franchise->id }}" 
                                            {{ old('franchise_id', $product->franchise_id) == $franchise->id ? 'selected' : '' }}>
                                        {{ $franchise->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Precio e Inventario</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Precio (€) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="price" 
                                   class="form-control" 
                                   value="{{ old('price', $product->price) }}"
                                   step="0.01"
                                   required
                                   style="border-radius: 15px;">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stock" 
                                   class="form-control" 
                                   value="{{ old('stock', $product->stock) }}"
                                   required
                                   style="border-radius: 15px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_preorder" 
                                   id="is_preorder"
                                   value="1"
                                   {{ old('is_preorder', $product->is_preorder) ? 'checked' : '' }}
                                   onchange="togglePreorder()">
                            <label class="form-check-label fw-semibold" for="is_preorder">
                                Este producto es una preventa
                            </label>
                        </div>
                    </div>

                    <div id="preorder-date" style="display: {{ $product->is_preorder ? 'block' : 'none' }};">
                        <label class="form-label fw-semibold">Fecha de Lanzamiento</label>
                        <input type="date" 
                               name="release_date" 
                               class="form-control" 
                               value="{{ old('release_date', $product->release_date?->format('Y-m-d')) }}"
                               style="border-radius: 15px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Imagen del Producto</h5>
@if($product->image)
    <div class="mb-3 text-center">
        @if(Str::startsWith($product->image, 'http'))
            <img src="{{ $product->image }}" 
                 class="img-fluid" 
                 style="max-height: 250px; border-radius: 15px;">
        @else
            <img src="{{ asset('storage/' . $product->image) }}" 
                 class="img-fluid" 
                 style="max-height: 250px; border-radius: 15px;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cambiar Imagen</label>
                        <input type="file" 
                               name="image" 
                               class="form-control" 
                               accept="image/*"
                               onchange="previewImage(event)"
                               style="border-radius: 15px;">
                        <small class="text-muted">Deja vacío para mantener la imagen actual</small>
                    </div>

                    <div id="image-preview" class="mt-3 text-center" style="display: none;">
                        <img id="preview" src="" class="img-fluid" style="max-height: 250px; border-radius: 15px;">
                    </div>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Configuración</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="featured" 
                               id="featured"
                               value="1"
                               {{ old('featured', $product->featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            <i class="bi bi-star-fill text-warning"></i> Producto destacado
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-check-circle"></i> Guardar Cambios
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
</script>
@endpush