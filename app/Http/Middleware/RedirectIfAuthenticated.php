<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Verificar si hay un token de autenticación en la sesión
        if ($request->session()->has('authToken')) {
            // Redirigir a la ruta HOME si el usuario ya está autenticado
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
