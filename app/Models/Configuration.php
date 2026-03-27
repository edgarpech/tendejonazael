<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Configuración.
 *
 * Almacena pares clave-valor para la configuración dinámica del sistema.
 * Permite agrupar configuraciones y castear valores automáticamente.
 *
 * @property int $id_configuration
 * @property string $key
 * @property string|null $value
 * @property string $group
 * @property string $type
 * @property string|null $description
 * @property int $is_public
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Configuration extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_configuration';

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtiene el valor de una configuración por su clave.
     *
     * @param string $key Clave de la configuración.
     * @param mixed $default Valor por defecto si no existe.
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $config = self::where('key', $key)->first();
        
        if (!$config) {
            return $default;
        }

        return self::castValue($config->value, $config->type);
    }

    /**
     * Establece o actualiza el valor de una configuración.
     *
     * @param string $key Clave de la configuración.
     * @param mixed $value Valor a almacenar.
     * @param string $group Grupo al que pertenece.
     * @param string $type Tipo de dato (string, boolean, integer, float, json).
     * @return self
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'string'): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );
    }

    /**
     * Castea un valor al tipo indicado.
     *
     * @param mixed $value Valor crudo.
     * @param string $type Tipo destino (boolean, integer, float, decimal, json, array, string).
     * @return mixed
     */
    protected static function castValue($value, string $type)
    {
        return match($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float', 'decimal' => (float) $value,
            'json', 'array' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Scope: filtra solo configuraciones públicas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope: filtra configuraciones por grupo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $group Nombre del grupo.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}