<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forzar HTTPS en producción
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            
            // Auto-ejecutar migraciones en producción (solo primera vez)
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // Ignorar errores si ya están migradas
            }
        }
    }
}