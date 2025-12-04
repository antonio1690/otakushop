{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Pedidos - OtakuShop')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-bag-check"></i> Mis Pedidos
        </h2>
    </div>
</div>

@if($orders->count() > 0)
<div class="row">
    <div class="col-12">
        @foreach($orders as $order)
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <div class="row align-items-center mb-3">
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-2">
                            Pedido #{{ $order->id }}
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
                        </h5>
                        <p class="text-muted mb-0">
                            <i class="bi bi-calendar"></i> {{ $order->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="h4 fw-bold mb-2" style="color: var(--primary-color);">
                            {{ number_format($order->total, 2) }}€
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary-custom btn-sm">
                            Ver Detalle
                        </a>
                    </div>
                </div>

                <hr>

                <!-- Lista compacta de productos -->
                <div class="row g-3">
                    @foreach($order->items->take(3) as $item)
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            @if($item->product->image)
                                @if(Str::startsWith($item->product->image, 'http'))
                                    <img src="{{ $item->product->image }}" 
                                        class="me-3" 
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;"
                                        alt="{{ $item->product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                        class="me-3" 
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;"
                                        alt="{{ $item->product->name }}">
                                @endif
                            @else
                                <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                    style="width: 60px; height: 60px; border-radius: 10px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold small">{{ Str::limit($item->product->name, 30) }}</div>
                                <small class="text-muted">x{{ $item->quantity }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($order->items->count() > 3)
                    <div class="col-md-4">
                        <div class="alert alert-light mb-0 text-center" style="border-radius: 10px;">
                            <i class="bi bi-three-dots"></i><br>
                            <small>+{{ $order->items->count() - 3 }} productos más</small>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Dirección de envío -->
                <div class="mt-3 p-3" style="background: #f8f9fa; border-radius: 15px;">
                    <small class="fw-semibold d-block mb-1">
                        <i class="bi bi-geo-alt"></i> Dirección de envío:
                    </small>
                    <small class="text-muted">{{ Str::limit($order->shipping_address, 100) }}</small>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
</div>

@else
<!-- Sin pedidos -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body text-center py-5">
                <i class="bi bi-bag-x" style="font-size: 5rem; color: var(--primary-color);"></i>
                <h3 class="mt-4 fw-bold">Aún no tienes pedidos</h3>
                <p class="text-muted mb-4">¡Empieza a comprar tus productos favoritos!</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-shop"></i> Explorar Catálogo
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
