<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Controlador de recuperación de contraseña.
 *
 * Genera una nueva contraseña aleatoria y la envía por correo.
 * Incluye rate limiting para prevenir abuso.
 */
class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario de recuperación de contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Genera y envía una nueva contraseña al correo del usuario.
     * Responde con mensaje genérico para no revelar si el email existe.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNewPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $key = 'forgot-password:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        RateLimiter::hit($key, 300);

        $user = User::where('email', $request->email)->where('is_active', 1)->first();

        if (!$user) {
            return back()->with('status', 'Si el correo existe en nuestro sistema, recibirás una nueva contraseña.');
        }

        $newPassword = Str::random(10);
        $user->update(['password' => $newPassword]);
        $user->resetLoginAttempts();

        Mail::send('emails.new-password', [
            'user' => $user,
            'password' => $newPassword,
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Tu nueva contraseña - Tendejón Azael');
        });

        SecurityLog::log('password_reset', $user->id_user, 'Password reset via email for ' . $user->email);

        return back()->with('status', 'Si el correo existe en nuestro sistema, recibirás una nueva contraseña.');
    }
}
