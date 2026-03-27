<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\SecurityLog;

/**
 * Controlador de inicio de sesión.
 *
 * Maneja autenticación con rate limiting, bloqueo por fuerza bruta
 * y registro de eventos de seguridad.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de login o redirige al dashboard si ya está autenticado.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesa el intento de login con validación, rate limiting y bloqueo temporal.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->checkTooManyFailedAttempts($request);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->isBlocked()) {
            throw ValidationException::withMessages([
                'email' => ['Tu cuenta ha sido bloqueada temporalmente. Intenta más tarde.'],
            ]);
        }

        if (!$user || !$user->is_active) {
            RateLimiter::hit($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $user->logLogin();
            
            RateLimiter::clear($this->throttleKey($request));

            return redirect()->intended(route('dashboard'));
        }

        if ($user) {
            $user->incrementLoginAttempts();
        }

        RateLimiter::hit($this->throttleKey($request));

        SecurityLog::log('login_failed', $user?->id_user, 'Failed login attempt for ' . $request->email);

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    /**
     * Verifica si se han excedido los intentos permitidos de login.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkTooManyFailedAttempts(Request $request)
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => ["Demasiados intentos. Por favor intenta en {$seconds} segundos."],
            ]);
        }
    }

    /**
     * Genera la clave de throttle combinando email e IP.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function throttleKey(Request $request): string
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }
}