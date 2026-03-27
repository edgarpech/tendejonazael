<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission;

/**
 * Proveedor de servicios de la aplicación.
 *
 * Registra los Gates de autorización dinámicamente
 * basados en los permisos activos de la base de datos.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios en el contenedor.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa la aplicación: registra Gates de permisos dinámicos.
     *
     * @return void
     */
    public function boot(): void
    {
        try {
            $permissions = Permission::where('is_active', 1)->get();
            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermission($permission->name);
                });
            }
        } catch (\Exception $e) {
            // Table may not exist during migrations
        }
    }
}
