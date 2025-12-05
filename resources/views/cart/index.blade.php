{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Carrito de Compras - OtakuShop')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="fw-bold mb-4">
            <i class="bi bi-cart3"></i> Mi Carrito de Compras
        </h2>
    </div>
</div>

@if($cartItems->count() > 0)
<div class="row">
    <!-- Lista de productos en el carrito -->
    <div class="col-lg-8 mb-4">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                @foreach($cartItems as $item)
                <div class="row align-items-center mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <!-- Imagen del producto -->
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

                    <!-- Información del producto -->
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                        <small class="text-muted">
                            {{ $item->product->category->name }} - {{ $item->product->franchise->name }}
                        </small>
                        <br>
                        <small class="fw-semibold" style="color: var(--primary-color);">
                            {{ number_format($item->product->price, 2) }}€ / unidad
                        </small>
                    </div>

                    <!-- Cantidad -->
                    <div class="col-md-3">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" 
                                   name="quantity" 
                                   value="{{ $item->quantity }}" 
                                   min="1" 
                                   max="{{ $item->product->is_preorder ? 10 : $item->product->stock }}"
                                   class="form-control form-control-sm" 
                                   style="border-radius: 10px; width: 70px;"
                                   onchange="this.form.submit()">
                            <button type="submit" class="btn btn-sm btn-primary-custom">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        @if(!$item->product->is_preorder && $item->quantity > $item->product->stock)
                            <small class="text-danger">
                                <i class="bi bi-exclamation-triangle"></i> Stock insuficiente
                            </small>
                        @endif
                    </div>

                    <!-- Subtotal y eliminar -->
                    <div class="col-md-3 text-end">
                        <div class="h5 fw-bold mb-2" style="color: var(--primary-color);">
                            {{ number_format($item->quantity * $item->product->price, 2) }}€
                        </div>
                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 10px;">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Resumen del pedido -->
    <div class="col-lg-4">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); position: sticky; top: 20px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Resumen del Pedido</h5>
                
                <div class="d-flex justify-content-between mb-3">
                    <span>Productos ({{ $cartItems->sum('quantity') }})</span>
                    <span class="fw-semibold">{{ number_format($total, 2) }}€</span>
                </div>
                
                <div class="d-flex justify-content-between mb-3">
                    <span>Envío</span>
                    <span class="text-success fw-semibold">GRATIS</span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="h5 fw-bold">Total</span>
                    <span class="h4 fw-bold" style="color: var(--primary-color);">
                        {{ number_format($total, 2) }}€
                    </span>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-credit-card"></i> Proceder al Pago
                    </a>
                    <a href="{{ route('catalog') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                        <i class="bi bi-arrow-left"></i> Seguir Comprando
                    </a>
                </div>

                <!-- Información adicional -->
                <div class="mt-4 p-3" style="background: #f8f9fa; border-radius: 15px;">
                    <div class="d-flex align-items-start mb-2">
                        <i class="bi bi-shield-check text-success me-2 mt-1"></i>
                        <small>Compra 100% segura</small>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <i class="bi bi-truck text-primary me-2 mt-1"></i>
                        <small>Envío gratis en todos los pedidos</small>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="bi bi-arrow-return-left text-info me-2 mt-1"></i>
                        <small>Devoluciones en 30 días</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<!-- Carrito vacío -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body text-center py-5">
                <i class="bi bi-cart-x" style="font-size: 5rem; color: var(--primary-color);"></i>
                <h3 class="mt-4 fw-bold">Tu carrito está vacío</h3>
                <p class="text-muted mb-4">¡Añade productos y empieza a comprar!</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-shop"></i> Ir al Catálogo
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection