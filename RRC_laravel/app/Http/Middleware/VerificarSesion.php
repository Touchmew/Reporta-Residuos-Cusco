<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesion
{
    /**
     * Verifica que el usuario tenga una sesión activa.
     * Si no existe usuario_id en sesión redirige al login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('usuario_id')) {
            return redirect('/login')->withErrors([
                'sesion' => 'Debes iniciar sesión para acceder.',
            ]);
        }

        return $next($request);
    }
}
