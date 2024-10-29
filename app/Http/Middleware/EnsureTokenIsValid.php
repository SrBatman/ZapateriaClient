<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('authToken')) {
            // Redirigir a la página de inicio de sesión si no hay token
            return redirect()->route('auth.login')->withErrors(['message' => 'Por favor, inicie sesión para acceder a esta página.']);
        }

        return $next($request);
    }
}
