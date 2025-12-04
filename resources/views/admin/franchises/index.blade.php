{{-- resources/views/admin/franchises/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Franquicias - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">
            <i class="bi bi-star"></i> Franquicias
        </h2>
        <p class="text-muted">Gestiona las franquicias de anime</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.franchises.create') }}" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Franquicia
        </a>
    </div>
</div>

<div class="card admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th width="100">Logo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th width="150">Productos</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($franchises as $franchise)
                    <tr>
                        <td class="fw-bold">#{{ $franchise->id }}</td>
                        <td>
                            @if($franchise->logo)
                                @if(Str::startsWith($franchise->logo, 'http'))
                                    <img src="{{ $franchise->logo }}" 
                                        class="img-thumbnail" 
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <img src="{{ asset('storage/' . $franchise->logo) }}" 
                                        class="img-thumbnail" 
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                                @endif
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; border-radius: 10px;">
                                    <i class="bi bi-star text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold">{{ $franchise->name }}</span>
                        </td>
                        <td>{{ Str::limit($franchise->description, 50) }}</td>
                        <td>
                            <span class="badge bg-info">{{ $franchise->products_count }} productos</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.franchises.edit', $franchise) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteFranchise({{ $franchise->id }})"
                                        {{ $franchise->products_count > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <form id="delete-form-{{ $franchise->id }}" 
                                  action="{{ route('admin.franchises.destroy', $franchise) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No hay franquicias creadas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($franchises->hasPages())
        <div class="p-4">
            {{ $franchises->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function deleteFranchise(id) {
    if (confirm('¿Estás seguro de eliminar esta franquicia?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush