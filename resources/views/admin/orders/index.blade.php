{{-- resources/views/admin/orders/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Pedidos - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">
            <i class="bi bi-bag-check"></i> Pedidos
        </h2>
        <p class="text-muted">Gestiona todos los pedidos de la tienda</p>
    </div>
</div>

<!-- Filtros -->
<div class="card admin-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       placeholder="Buscar por ID o nombre de cliente..."
                       value="{{ request('search') }}"
                       style="border-radius: 15px;">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select" style="border-radius: 15px;">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="procesando" {{ request('status') == 'procesando' ? 'selected' : '' }}>Procesando</option>
                    <option value="enviado" {{ request('status') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                    <option value="entregado" {{ request('status') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
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

<!-- Tabla de pedidos -->
<div class="card admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold">#{{ $order->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $order->items->count() }} productos</span>
                        </td>
                        <td class="fw-bold" style="color: var(--primary-color);">
                            {{ number_format($order->total, 2) }}€
                        </td>
                        <td>
                            @switch($order->status)
                                @case('pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                    @break
                                @case('procesando')
                                    <span class="badge bg-info">Procesando</span>
                                    @break
                                @case('enviado')
                                    <span class="badge bg-primary">Enviado</span>
                                    @break
                                @case('entregado')
                                    <span class="badge bg-success">Entregado</span>
                                    @break
                                @case('cancelado')
                                    <span class="badge bg-danger">Cancelado</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="btn btn-sm btn-outline-primary"
                               title="Ver detalle">
                                <i class="bi bi-eye"></i>
                            </a>
                            
                            @if($order->status === 'cancelado')
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteOrder({{ $order->id }})"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                            
                            <form id="delete-form-{{ $order->id }}" 
                                  action="{{ route('admin.orders.destroy', $order) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No se encontraron pedidos</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="p-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function deleteOrder(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este pedido?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush