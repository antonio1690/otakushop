{{-- resources/views/orders/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout - OtakuShop')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-credit-card"></i> Finalizar Compra
        </h2>
        <!-- Progress Steps -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-center flex-fill">
                    <div class="rounded-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <small class="d-block mt-2 fw-semibold">Carrito</small>
                </div>
                <div class="flex-fill" style="height: 2px; background: var(--primary-color);"></div>
                <div class="text-center flex-fill">
                    <div class="rounded-circle text-white mx-auto d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: var(--primary-color);">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <small class="d-block mt-2 fw-semibold">Pago</small>
                </div>
                <div class="flex-fill" style="height: 2px; background: #dee2e6;"></div>
                <div class="text-center flex-fill">
                    <div class="rounded-circle bg-light text-muted mx-auto d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <small class="d-block mt-2 text-muted">Confirmación</small>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Formulario de envío -->
        <div class="col-lg-8 mb-4">
            <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-truck"></i> Información de Envío
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre Completo</label>
                        <input type="text" 
                               class="form-control" 
                               value="{{ auth()->user()->name }}" 
                               readonly
                               style="border-radius: 15px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" 
                               class="form-control" 
                               value="{{ auth()->user()->email }}" 
                               readonly
                               style="border-radius: 15px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dirección de Envío <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" 
                                  class="form-control @error('shipping_address') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Calle, número, piso, código postal, ciudad, país..."
                                  required
                                  style="border-radius: 15px;">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Por favor, incluye todos los detalles necesarios para el envío</small>
                    </div>
                </div>
            </div>

            <!-- Método de pago (simulado) -->
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-credit-card-2-front"></i> Método de Pago
                    </h5>

                    <div class="alert alert-info" style="border-radius: 15px;">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Nota:</strong> Este es un proyecto de demostración. El pago es simulado.
                    </div>

                    <div class="form-check p-3 mb-3" style="background: #f8f9fa; border-radius: 15px;">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" checked>
                        <label class="form-check-label fw-semibold" for="card">
                            <i class="bi bi-credit-card text-primary"></i> Tarjeta de Crédito/Débito
                        </label>
                    </div>

                    <div class="form-check p-3 mb-3" style="background: #f8f9fa; border-radius: 15px;">
                        <input class="form-check-input" type="radio" name="payment_method" id="paypal">
                        <label class="form-check-label fw-semibold" for="paypal">
                            <i class="bi bi-paypal text-info"></i> PayPal
                        </label>
                    </div>

                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 15px;">
                        <input class="form-check-input" type="radio" name="payment_method" id="transfer">
                        <label class="form-check-label fw-semibold" for="transfer">
                            <i class="bi bi-bank text-success"></i> Transferencia Bancaria
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen del pedido -->
        <div class="col-lg-4">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); position: sticky; top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Resumen del Pedido</h5>

                    <!-- Lista de productos -->
                    <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                        @foreach($cartItems as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     class="me-3" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;"
                                     alt="{{ $item->product->name }}">
                            @else
                                <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; border-radius: 10px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ Str::limit($item->product->name, 30) }}</div>
                                <small class="text-muted">x{{ $item->quantity }}</small>
                            </div>
                            <div class="fw-semibold">
                                {{ number_format($item->quantity * $item->product->price, 2) }}€
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span class="fw-semibold">{{ number_format($total, 2) }}€</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío</span>
                        <span class="text-success fw-semibold">GRATIS</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>IVA (21%)</span>
                        <span class="fw-semibold">{{ number_format($total * 0.21, 2) }}€</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5 fw-bold">Total</span>
                        <span class="h4 fw-bold" style="color: var(--primary-color);">
                            {{ number_format($total * 1.21, 2) }}€
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-check-circle"></i> Confirmar Pedido
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                            <i class="bi bi-arrow-left"></i> Volver al Carrito
                        </a>
                    </div>

                    <!-- Garantías -->
                    <div class="mt-4 p-3" style="background: #f8f9fa; border-radius: 15px;">
                        <div class="d-flex align-items-start mb-2">
                            <i class="bi bi-shield-check text-success me-2 mt-1"></i>
                            <small>Pago 100% seguro</small>
                        </div>
                        <div class="d-flex align-items-start mb-2">
                            <i class="bi bi-truck text-primary me-2 mt-1"></i>
                            <small>Envío en 24-48h</small>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-arrow-return-left text-info me-2 mt-1"></i>
                            <small>Garantía de devolución</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection