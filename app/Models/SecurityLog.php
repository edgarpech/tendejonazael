<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de Registro de Seguridad.
 *
 * Almacena eventos de seguridad del sistema como inicios de sesión,
 * intentos fallidos, cambios de contraseña, etc.
 *
 * @property int $id_security_log
 * @property int|null $user_id
 * @property string $event_type
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $description
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $created_at
 */
class SecurityLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_security_log';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'event_type',
        'ip_address',
        'user_agent',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Obtiene el usuario asociado al registro de seguridad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, SecurityLog>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Registra un evento de seguridad con la IP y user-agent del request actual.
     *
     * @param string $eventType Tipo de evento (login_success, login_failed, etc.).
     * @param int|null $userId ID del usuario involucrado.
     * @param string|null $description Descripción legible del evento.
     * @param array $metadata Datos adicionales del evento.
     * @return self
     */
    public static function log(string $eventType, ?int $userId = null, ?string $description = null, array $metadata = []): self
    {
        return self::create([
            'user_id' => $userId,
            'event_type' => $eventType,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Scope: filtra registros por tipo de evento.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type Tipo de evento.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    /**
     * Scope: filtra registros por usuario.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId ID del usuario.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}