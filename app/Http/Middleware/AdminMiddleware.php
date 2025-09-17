<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Manejar una solicitud entrante.
     */
    public function handle($request, Closure $next)
    {
        // Verificamos si el usuario está autenticado y si su rol es "admin"
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder.');
        }
        return $next($request);
    }
}
