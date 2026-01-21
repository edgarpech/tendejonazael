<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $user = auth()->user();
        
        if (!$user->role) {
            abort(403, 'No tienes un rol asignado.');
        }

        foreach ($roles as $role) {
            if ($user->role->name === $role) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}