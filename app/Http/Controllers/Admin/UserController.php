<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')->get();

        if ($request->ajax()) {
            return response()->json($users);
        }

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id_role',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active');

        $user = User::create($validated);
        $user->load('role');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario creado exitosamente', 'data' => $user]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id_role',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);
        $user->load('role');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario actualizado exitosamente', 'data' => $user]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        if ($user->id_user === auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'No puedes eliminarte a ti mismo'], 422);
            }
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminarte a ti mismo');
        }

        $user->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
