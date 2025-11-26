{{-- resources/views/admin/franchises/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Crear Franquicia - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.franchises.index') }}">Franquicias</a></li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
        </nav>
        <h2 class="fw-bold">
            <i class="bi bi-plus-circle"></i> Nueva Franquicia
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card admin-card">
            <div class="card-body p-4">
                <form action="{{ route('admin.franchises.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}"
                               placeholder="Ej: One Piece"
                               required
                               style="border-radius: 15px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción</label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Describe la franquicia..."
                                  style="border-radius: 15px;">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Logo</label>
                        <input type="file" 
                               name="logo" 
                               class="form-control @error('logo') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewLogo(event)"
                               style="border-radius: 15px;">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Formatos: JPG, PNG, GIF, SVG. Máximo: 2MB</small>
                        
                        <div id="logo-preview" class="mt-3 text-center" style="display: none;">
                            <img id="preview" 
                                 src="" 
                                 class="img-fluid" 
                                 style="max-height: 200px; border-radius: 15px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-check-circle"></i> Crear Franquicia
                        </button>
                        <a href="{{ route('admin.franchises.index') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewLogo(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        const container = document.getElementById('logo-preview');
        preview.src = reader.result;
        container.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush