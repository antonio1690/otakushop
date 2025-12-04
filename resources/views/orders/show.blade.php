
{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle Pedido #' . $order->id . ' - OtakuShop')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Mis Pedidos</a></li>
        <li class="breadcrumb-item active">Pedido #{{ $order->id }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12 mb-4">
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
    <!-- Detalles del pedido -->
    <div class="col-lg-8 mb-4">
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-box-seam"></i> Productos
                </h5>

                @foreach($order->items as $item)
                <div class="row align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="col-md-2">
                        @if($item->product->image)
                            @if(Str::startsWith($item->product->image, 'http'))
                                <img src="{{ $item->product->image }}" 
                                    class="img-fluid" 
                                    style="border-radius: 15px; width: 100%; height: 80px; object-fit: cover;"
                                    alt="{{ $item->product->name }}">
                            @else
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                    class="img-fluid" 
                                    style="border-radius: 15px; width: 100%; height: 80px; object-fit: cover;"
                                    alt="{{ $item->product->name }}">
                            @endif
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                style="border-radius: 15px; height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                        <small class="text-muted">
                            {{ $item->product->category->name }} - {{ $item->product->franchise->name }}
                        </small>
                        <br>
                        <small class="fw-semibold" style="color: var(--primary-color);">
                            {{ number_format($item->price, 2) }}€ x {{ $item->quantity }}
                        </small>
                    </div>

                    <div class="col-md-4 text-end">
                        <div class="h5 fw-bold" style="color: var(--primary-color);">
                            {{ number_format($item->price * $item->quantity, 2) }}€
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Información de envío -->
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-truck"></i> Información de Envío
                </h5>

                <div class="mb-3">
                    <strong>Dirección de envío:</strong>
                    <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                </div>

                <div class="mb-3">
                    <strong>Fecha del pedido:</strong>
                    <p class="text-muted mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <strong>Estado del pedido:</strong>
                    <p class="mb-0">
                        @switch($order->status)
                            @case('pendiente')
                                <span class="text-warning">⏳ Tu pedido está pendiente de procesamiento</span>
                                @break
                            @case('procesando')
                                <span class="text-info">📦 Estamos preparando tu pedido</span>
                                @break
                            @case('enviado')
                                <span class="text-primary">🚚 Tu pedido está en camino</span>
                                @break
                            @case('entregado')
                                <span class="text-success">✅ Pedido entregado</span>
                                @break
                            @case('cancelado')
                                <span class="text-danger">❌ Pedido cancelado</span>
                                @break
                        @endswitch
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen -->
    <div class="col-lg-4">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); position: sticky; top: 20px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Resumen</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-semibold">{{ number_format($order->total, 2) }}€</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Envío</span>
                    <span class="text-success fw-semibold">GRATIS</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <span class="h5 fw-bold">Total</span>
                    <span class="h4 fw-bold" style="color: var(--primary-color);">
                        {{ number_format($order->total, 2) }}€
                    </span>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                        <i class="bi bi-arrow-left"></i> Volver a Mis Pedidos
                    </a>
                    <a href="{{ route('catalog') }}" class="btn btn-primary-custom">
                        <i class="bi bi-shop"></i> Seguir Comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection