<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de verificación de rol.
 *
 * Verifica que el usuario autenticado tenga uno de los roles especificados.
 */
class CheckRole
{
    /**
     * Verifica que el usuario tenga alguno de los roles indicados.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles Nombres de roles permitidos.
     * @return \Symfony\Component\HttpFoundation\Response
     */
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