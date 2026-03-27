<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Rol.
 *
 * Define un rol del sistema con permisos asociados.
 * El nivel (level) determina la jerarquía de acceso.
 *
 * @property int $id_role
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property int $level
 * @property int $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_role';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'level',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'is_active' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los permisos asignados a este rol.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Permission>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
                    ->withTimestamps();
    }

    /**
     * Obtiene los usuarios que tienen este rol.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id_role');
    }

    /**
     * Verifica si el rol tiene un permiso específico.
     *
     * @param string $permissionName Nombre del permiso a verificar.
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Verifica si el rol es administrador (name='admin' o level>=3).
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin' || $this->level >= 3;
    }
}