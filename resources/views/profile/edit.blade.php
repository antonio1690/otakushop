{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi Perfil - OtakuShop')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="bi bi-person-circle"></i> Mi Perfil
        </h2>
        <p class="text-muted">Gestiona tu información personal y preferencias</p>
    </div>
</div>

<div class="row">
    <!-- Sidebar - Información del Usuario -->
    <div class="col-lg-4 mb-4">
        <!-- Card de Avatar y Datos Básicos -->
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body text-center p-4">
                <!-- Avatar -->
                <div class="position-relative d-inline-block mb-3">
                    @if($user->avatar)
                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($user->avatar) }}" 
                            alt="Avatar"
                            class="rounded-circle"
                            style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--primary-color); box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                            style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; font-size: 3rem; font-weight: bold; border: 4px solid white; box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <!-- Botón cambiar avatar -->
                    <button type="button" 
                            class="btn btn-sm btn-primary-custom position-absolute" 
                            style="bottom: 0; right: 0; border-radius: 50%; width: 35px; height: 35px; padding: 0;"
                            data-bs-toggle="modal" 
                            data-bs-target="#avatarModal">
                        <i class="bi bi-camera-fill"></i>
                    </button>
                </div>

                <!-- Nombre y Email -->
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>

                <!-- Badge de rol -->
                @if($user->isAdmin())
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 0.5rem 1.5rem; border-radius: 20px; font-size: 0.9rem;">
                        <i class="bi bi-shield-check"></i> Administrador
                    </span>
                @else
                    <span class="badge" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 0.5rem 1.5rem; border-radius: 20px; font-size: 0.9rem;">
                        <i class="bi bi-person"></i> Cliente
                    </span>
                @endif

                <!-- Miembro desde -->
                <div class="mt-3 p-3" style="background: #f8f9fa; border-radius: 15px;">
                    <small class="text-muted d-block">Miembro desde</small>
                    <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        <!-- Card de Estadísticas -->
        <div class="card mt-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-graph-up"></i> Mis Estadísticas
                </h5>

                <!-- Total Pedidos -->
                <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                    <div class="text-white">
                        <small class="d-block opacity-75">Total Pedidos</small>
                        <h3 class="mb-0 fw-bold">{{ $totalOrders }}</h3>
                    </div>
                    <i class="bi bi-bag-check-fill text-white" style="font-size: 2.5rem; opacity: 0.5;"></i>
                </div>

                <!-- Total Gastado -->
                <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
                    <div class="text-white">
                        <small class="d-block opacity-75">Total Gastado</small>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalSpent, 2) }}€</h3>
                    </div>
                    <i class="bi bi-currency-euro text-white" style="font-size: 2.5rem; opacity: 0.5;"></i>
                </div>

                <!-- Pedidos Pendientes -->
                <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px;">
                    <div class="text-white">
                        <small class="d-block opacity-75">Pendientes</small>
                        <h3 class="mb-0 fw-bold">{{ $pendingOrders }}</h3>
                    </div>
                    <i class="bi bi-clock-history text-white" style="font-size: 2.5rem; opacity: 0.5;"></i>
                </div>

                <!-- Pedidos Completados -->
                <div class="d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 15px;">
                    <div class="text-white">
                        <small class="d-block opacity-75">Completados</small>
                        <h3 class="mb-0 fw-bold">{{ $completedOrders }}</h3>
                    </div>
                    <i class="bi bi-check-circle-fill text-white" style="font-size: 2.5rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="col-lg-8">
        <!-- Editar Información Personal -->
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person-fill"></i> Información Personal
                </h5>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre Completo</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa;">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   style="border-radius: 0 15px 15px 0;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa;">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   style="border-radius: 0 15px 15px 0;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($user->email_verified_at)
                            <small class="text-success">
                                <i class="bi bi-check-circle-fill"></i> Email verificado
                            </small>
                        @endif
                    </div>

                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                </h5>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Contraseña Actual -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Contraseña Actual</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa;">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                   style="border-radius: 0 15px 15px 0;">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nueva Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa;">
                                <i class="bi bi-key"></i>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                   style="border-radius: 0 15px 15px 0;">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: #f8f9fa;">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="form-control"
                                   style="border-radius: 0 15px 15px 0;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-shield-check"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>

        <!-- Últimos Pedidos -->
        @if($recentOrders->count() > 0)
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history"></i> Últimos Pedidos
                    </h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 15px;">
                        Ver todos
                    </a>
                </div>

                @foreach($recentOrders as $order)
                <div class="d-flex justify-content-between align-items-center p-3 mb-2" style="background: #f8f9fa; border-radius: 15px;">
                    <div>
                        <strong>Pedido #{{ $order->id }}</strong>
                        <br>
                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="text-end">
                        <strong style="color: var(--primary-color);">{{ number_format($order->total, 2) }}€</strong>
                        <br>
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
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Zona de Peligro -->
        <div class="card" style="border-radius: 20px; border: 2px solid #dc3545; background: #fff5f5;">
            <div class="card-body p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i> Zona de Peligro
                </h5>
                <p class="text-muted mb-3">
                    Al eliminar tu cuenta, todos tus datos serán eliminados permanentemente. Esta acción no se puede deshacer.
                </p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash"></i> Eliminar Cuenta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar avatar -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-camera"></i> Cambiar Avatar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="text-center mb-3">
                        <img id="avatarPreview"
                            src="{{ $user->avatar ? \App\Helpers\ImageHelper::getImageUrl($user->avatar) : asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-3"
                            style="width: 150px; height: 150px; object-fit: cover; border: 4px solid var(--primary-color);">
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label fw-semibold">Selecciona una imagen</label>
                        <input type="file" 
                            id="avatar" 
                            name="avatar" 
                            class="form-control" 
                            accept="image/*"
                            onchange="previewAvatar(this)"
                            style="border-radius: 15px;">
                        <small class="text-muted">JPG, PNG o GIF. Máximo 2MB</small>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-upload"></i> Subir Avatar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar cuenta -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 bg-danger text-white">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Confirma tu contraseña</label>
                        <input type="password" 
                            id="password" 
                            name="password" 
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                            required
                            style="border-radius: 15px;">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Sí, Eliminar Mi Cuenta
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
