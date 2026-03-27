<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de verificación de permiso.
 *
 * Verifica que el usuario autenticado tenga el permiso específico.
 */
class CheckPermission
{
    /**
     * Verifica que el usuario tenga el permiso indicado.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission Nombre del permiso requerido.
     * @return \Symfony\Component\HttpFoundation\Response
     */
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