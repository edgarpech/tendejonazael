<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Usuario.
 *
 * Representa un usuario autenticable del sistema con rol, permisos,
 * control de intentos de login y bloqueo por fuerza bruta.
 *
 * @property int $id_user
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int|null $role_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property int $login_attempts
 * @property \Illuminate\Support\Carbon|null $blocked_until
 * @property string|null $ip_address
 * @property string|null $session_token
 * @property array|null $preferences
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'last_login_at',
        'login_attempts',
        'blocked_until',
        'ip_address',
        'session_token',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'session_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'integer',
        'last_login_at' => 'datetime',
        'login_attempts' => 'integer',
        'blocked_until' => 'datetime',
        'preferences' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene el rol asignado al usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Role, User>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }

    /**
     * Obtiene los registros de seguridad del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<SecurityLog>
     */
    public function securityLogs(): HasMany
    {
        return $this->hasMany(SecurityLog::class, 'user_id', 'id_user');
    }

    /**
     * Verifica si el usuario tiene un permiso específico a través de su rol.
     *
     * @param string $permission Nombre del permiso.
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role && $this->role->hasPermission($permission);
    }

    /**
     * Verifica si el usuario tiene rol de administrador.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->isAdmin();
    }

    /**
     * Verifica si el usuario está bloqueado temporalmente por intentos fallidos.
     *
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->blocked_until && $this->blocked_until->isFuture();
    }

    /**
     * Reinicia el contador de intentos de login y elimina el bloqueo.
     *
     * @return void
     */
    public function resetLoginAttempts(): void
    {
        $this->update([
            'login_attempts' => 0,
            'blocked_until' => null,
        ]);
    }

    /**
     * Incrementa el contador de intentos fallidos de login.
     * Si alcanza 5 intentos, bloquea al usuario por 15 minutos.
     *
     * @return void
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
        
        if ($this->login_attempts >= 5) {
            $this->update([
                'blocked_until' => now()->addMinutes(15),
            ]);
        }
    }

    /**
     * Registra un inicio de sesión exitoso: actualiza fecha, IP y resetea intentos.
     *
     * @return void
     */
    public function logLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'ip_address' => request()->ip(),
        ]);
        
        $this->resetLoginAttempts();
        
        SecurityLog::log('login_success', $this->id_user, 'User logged in successfully');
    }
}