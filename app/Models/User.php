<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'login_attempts' => 'integer',
        'blocked_until' => 'datetime',
        'preferences' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function securityLogs(): HasMany
    {
        return $this->hasMany(SecurityLog::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->role && $this->role->hasPermission($permission);
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->isAdmin();
    }

    public function isBlocked(): bool
    {
        return $this->blocked_until && $this->blocked_until->isFuture();
    }

    public function resetLoginAttempts(): void
    {
        $this->update([
            'login_attempts' => 0,
            'blocked_until' => null,
        ]);
    }

    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
        
        if ($this->login_attempts >= 5) {
            $this->update([
                'blocked_until' => now()->addMinutes(15),
            ]);
        }
    }

    public function logLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'ip_address' => request()->ip(),
        ]);
        
        $this->resetLoginAttempts();
        
        SecurityLog::log('login_success', $this->id, 'User logged in successfully');
    }
}