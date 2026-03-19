<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\SecurityLog;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id_user . ',id_user'],
        ]);

        $user->update($validated);

        SecurityLog::log('profile_updated', $user->id_user, 'User updated profile information');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Datos actualizados correctamente']);
        }

        return redirect()->route('profile.edit')->with('success', 'Datos actualizados correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'La contraseña actual no es correcta'], 422);
            }
            return back()->withErrors([
                'current_password' => 'La contraseña actual no es correcta.',
            ]);
        }

        $user->update([
            'password' => $request->password,
        ]);

        SecurityLog::log('password_changed', $user->id_user, 'User changed password from profile');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
        }

        return redirect()->route('profile.edit')->with('success', 'Contraseña actualizada correctamente.');
    }
}
