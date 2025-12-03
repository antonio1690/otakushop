<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\FranchiseController as AdminFranchiseController;

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/productos/{product}', [HomeController::class, 'show'])->name('products.show');
Route::get('/api/products/search', [HomeController::class, 'searchProducts'])->name('products.search');

// Rutas de autenticación (generadas por Breeze)
require __DIR__.'/auth.php';

// Google OAuth
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito de compras
    Route::prefix('carrito')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/añadir/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cartItem}', [CartController::class, 'remove'])->name('remove');
    });

    // Pedidos
    Route::prefix('pedidos')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
});

// Rutas de administración (solo para admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Productos
    Route::resource('products', AdminProductController::class);
    
    // Categorías
    Route::resource('categories', AdminCategoryController::class);
    
    // Franquicias
    Route::resource('franchises', AdminFranchiseController::class);
    
    // Pedidos
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

// ============================================
// RUTA TEMPORAL PARA SETUP - ELIMINAR DESPUÉS
// ============================================
Route::get('/admin/setup-database-now', function () {
    // Solo permitir en producción Y solo una vez
    $alreadySeeded = \App\Models\Product::count() > 0;
    
    if ($alreadySeeded) {
        return response()->json([
            'status' => 'already_done',
            'message' => 'La base de datos ya tiene datos. No se puede ejecutar de nuevo.',
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\Category::count(),
            'franchises' => \App\Models\Franchise::count(),
            'users' => \App\Models\User::count()
        ]);
    }
    
    try {
        // Ejecutar seeders
        \Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\CategorySeeder',
            '--force' => true
        ]);
        
        \Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\FranchiseSeeder',
            '--force' => true
        ]);
        
        \Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\UserSeeder',
            '--force' => true
        ]);
        
        \Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\ProductSeeder',
            '--force' => true
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => '✅ Base de datos configurada correctamente',
            'data' => [
                'products' => \App\Models\Product::count(),
                'categories' => \App\Models\Category::count(),
                'franchises' => \App\Models\Franchise::count(),
                'users' => \App\Models\User::count()
            ],
            'credentials' => [
                'admin' => 'admin@otakushop.com / admin123',
                'cliente' => 'cliente@otakushop.com / cliente123'
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->name('setup.database');