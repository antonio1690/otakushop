{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detalle Pedido #' . $order->id . ' - Admin OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pedidos</a></li>
                <li class="breadcrumb-item active">Pedido #{{ $order->id }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0">
                Pedido #{{ $order->id }}
            </h2>
            @switch($order->status)
                @case('pendiente')
                    <span class="badge bg-warning fs-6">Pendiente</span>
                    @break
                @case('procesando')
                    <span class="badge bg-info fs-6">Procesando</span>
                    @break
                @case('enviado')
                    <span class="badge bg-primary fs-6">Enviado</span>
                    @break
                @case('entregado')
                    <span class="badge bg-success fs-6">Entregado</span>
                    @break
                @case('cancelado')
                    <span class="badge bg-danger fs-6">Cancelado</span>
                    @break
            @endswitch
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Productos del pedido -->
        <div class="card admin-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Productos del Pedido</h5>
                
                @foreach($order->items as $item)
                <div class="row align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="col-md-2">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 class="img-fluid" 
                                 style="border-radius: 10px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 80px; border-radius: 10px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">{{ $item->product->name }}</h6>
                        <small class="text-muted">
                            {{ $item->product->category->name }} - {{ $item->product->franchise->name }}
                        </small>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="badge bg-light text-dark">x{{ $item->quantity }}</span>
                        <div class="small text-muted">{{ number_format($item->price, 2) }}€/u</div>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="fw-bold" style="color: var(--primary-color);">
                            {{ number_format($item->price * $item->quantity, 2) }}€
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="card admin-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Información del Cliente</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nombre:</strong>
                        <p class="text-muted mb-0">{{ $order->user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <p class="text-muted mb-0">{{ $order->user->email }}</p>
                    </div>
                    <div class="col-12">
                        <strong>Dirección de envío:</strong>
                        <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Cambiar estado -->
        <div class="card admin-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Cambiar Estado</h5>
                
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estado del Pedido</label>
                        <select name="status" class="form-select" style="border-radius: 15px;">
                            <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="procesando" {{ $order->status == 'procesando' ? 'selected' : '' }}>Procesando</option>
                            <option value="enviado" {{ $order->status == 'enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-check-circle"></i> Actualizar Estado
                    </button>
                </form>
            </div>
        </div>

        <!-- Resumen -->
        <div class="card admin-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Resumen</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span class="fw-semibold">{{ number_format($order->total, 2) }}€</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Envío:</span>
                    <span class="text-success fw-semibold">GRATIS</span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between">
                    <span class="h5 fw-bold">Total:</span>
                    <span class="h5 fw-bold" style="color: var(--primary-color);">
                        {{ number_format($order->total, 2) }}€
                    </span>
                </div>
                
                <div class="mt-3 p-3" style="background: #f8f9fa; border-radius: 15px;">
                    <small>
                        <i class="bi bi-calendar"></i> 
                        <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100" style="border-radius: 15px;">
            <i class="bi bi-arrow-left"></i> Volver a Pedidos
        </a>
    </div>
</div>

@endsection