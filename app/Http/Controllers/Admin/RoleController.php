<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * Controlador de administración de roles.
 *
 * CRUD de roles con asignación de permisos.
 */
class RoleController extends Controller
{
    /**
     * Lista todos los roles con sus permisos y conteos de usuarios.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->withCount(['users', 'permissions'])->orderBy('level', 'desc')->get();

        if ($request->ajax()) {
            return response()->json($roles);
        }

        $permissions = Permission::where('is_active', 1)->orderBy('module')->orderBy('action')->get();
        $modules = $permissions->groupBy('module');

        return view('admin.roles.index', compact('roles', 'modules'));
    }

    /**
     * Crea un nuevo rol y sincroniza los permisos seleccionados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:1|max:3',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id_permission',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
            'is_active' => 1,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rol creado exitosamente']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado exitosamente');
    }

    /**
     * Actualiza un rol y sincroniza los permisos seleccionados.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id_role . ',id_role',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:1|max:3',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id_permission',
        ]);

        $role->update([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rol actualizado exitosamente']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    /**
     * Elimina un rol si no es admin y no tiene usuarios asignados (soft delete).
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el rol de administrador'], 422);
            }
            return redirect()->route('admin.roles.index')->with('error', 'No se puede eliminar el rol de administrador');
        }

        if ($role->users()->count() > 0) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar un rol que tiene usuarios asignados'], 422);
            }
            return redirect()->route('admin.roles.index')->with('error', 'No se puede eliminar un rol que tiene usuarios asignados');
        }

        $role->permissions()->detach();
        $role->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rol eliminado exitosamente']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
