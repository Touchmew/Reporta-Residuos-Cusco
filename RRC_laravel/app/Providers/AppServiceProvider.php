<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ AQUÍ Arriba

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Si la variable FORCE_HTTPS que pusimos en Railway está activa, forzamos https
        if (env('FORCE_HTTPS') === true || config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}


