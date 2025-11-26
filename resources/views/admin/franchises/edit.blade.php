{{-- resources/views/admin/franchises/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Editar Franquicia - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.franchises.index') }}">Franquicias</a></li>
                <li class="breadcrumb-item active">Editar: {{ $franchise->name }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold">
            <i class="bi bi-pencil"></i> Editar Franquicia
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card admin-card">
            <div class="card-body p-4">
                <form action="{{ route('admin.franchises.update', $franchise) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               value="{{ old('name', $franchise->name) }}"
                               required
                               style="border-radius: 15px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción</label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="4"
                                  style="border-radius: 15px;">{{ old('description', $franchise->description) }}</textarea>
                    </div>

                    @if($franchise->logo)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $franchise->logo) }}" 
                             class="img-fluid" 
                             style="max-height: 150px; border-radius: 15px;">
                        <p class="text-muted small mt-2">Logo actual</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Cambiar Logo</label>
                        <input type="file" 
                               name="logo" 
                               class="form-control" 
                               accept="image/*"
                               onchange="previewLogo(event)"
                               style="border-radius: 15px;">
                        <small class="text-muted">Deja vacío para mantener el logo actual</small>
                        
                        <div id="logo-preview" class="mt-3 text-center" style="display: none;">
                            <img id="preview" src="" class="img-fluid" style="max-height: 150px; border-radius: 15px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
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