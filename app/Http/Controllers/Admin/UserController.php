<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'blocked' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['blocked'] = $request->has('blocked');

        User::create($validated);

        return redirect()->route('admin.users.index')
                       ->with('success', 'Usuario creado exitosamente');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'blocked' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['blocked'] = $request->has('blocked');

        $user->update($validated);

        return redirect()->route('admin.users.index')
                       ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'No puedes eliminarte a ti mismo');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'Usuario eliminado exitosamente');
    }
}