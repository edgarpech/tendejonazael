<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SecurityLog;

/**
 * Controlador de cierre de sesión.
 *
 * Registra el evento de logout y destruye la sesión del usuario.
 */
class LogoutController extends Controller
{
    /**
     * Cierra la sesión del usuario, invalida la sesión y regenera el token CSRF.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            SecurityLog::log('logout', $user->id_user, 'User logged out');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}