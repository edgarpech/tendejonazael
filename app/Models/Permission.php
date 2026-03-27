<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo de Permiso.
 *
 * Define un permiso del sistema que puede asignarse a roles.
 * Cada permiso tiene un módulo y una acción asociada.
 *
 * @property int $id_permission
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property string $module
 * @property string $action
 * @property int $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'action',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los roles que tienen este permiso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id')
                    ->withTimestamps();
    }
}