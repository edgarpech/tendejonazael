<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $user = auth()->user();

        if (!$user->hasPermission($permission)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}