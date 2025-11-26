{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Categorías - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">
            <i class="bi bi-tag"></i> Categorías
        </h2>
        <p class="text-muted">Gestiona las categorías de productos</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Categoría
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
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th width="150">Productos</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="fw-bold">#{{ $category->id }}</td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $category->name }}</span>
                        </td>
                        <td>{{ Str::limit($category->description, 60) }}</td>
                        <td>
                            <span class="badge bg-info">{{ $category->products_count }} productos</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteCategory({{ $category->id }})"
                                        {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <form id="delete-form-{{ $category->id }}" 
                                  action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No hay categorías creadas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="p-4">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function deleteCategory(id) {
    if (confirm('¿Estás seguro de eliminar esta categoría?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush