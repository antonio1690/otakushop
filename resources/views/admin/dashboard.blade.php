{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Panel de Administración - OtakuShop')

@section('admin-content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h2>
        <p class="text-muted">Bienvenido al panel de administración, {{ auth()->user()->name }}</p>
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row g-4 mb-5">
    <!-- Total Productos -->
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75">Total Productos</p>
                        <h2 class="fw-bold mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-white text-decoration-none small">
                    Ver productos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Pedidos -->
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75">Total Pedidos</p>
                        <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-bag-check fs-4"></i>
                    </div>
                </div>
                <a href="#" class="text-white text-decoration-none small">
                    Ver pedidos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Usuarios -->
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75">Total Clientes</p>
                        <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <span class="text-white text-decoration-none small">
                    Usuarios registrados
                </span>
            </div>
        </div>
    </div>

    <!-- Pedidos Pendientes -->
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75">Pedidos Pendientes</p>
                        <h2 class="fw-bold mb-0">{{ $pendingOrders }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
                <span class="text-white text-decoration-none small">
                    Requieren atención
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Pedidos Recientes -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history"></i> Pedidos Recientes
                    </h5>
                    <a href="#" class="btn btn-sm btn-primary-custom">Ver todos</a>
                </div>

                @if($recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order->id }}</td>
                                <td>
                                    <i class="bi bi-person-circle text-primary"></i>
                                    {{ $order->user->name }}
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
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No hay pedidos recientes</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection