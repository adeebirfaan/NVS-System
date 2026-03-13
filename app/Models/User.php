<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyEmail;

    public const ROLE_PUBLIC = 'public';
    public const ROLE_MCMC = 'mcmc';
    public const ROLE_AGENCY = 'agency';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'role',
        'agency_id',
        'is_active',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class)->unread();
    }

    public function isPublic(): bool
    {
        return $this->role === self::ROLE_PUBLIC;
    }

    public function isMcmc(): bool
    {
        return $this->role === self::ROLE_MCMC;
    }

    public function isAgency(): bool
    {
        return $this->role === self::ROLE_AGENCY;
    }

    public function canAccessDashboard(): bool
    {
        return in_array($this->role, [self::ROLE_MCMC, self::ROLE_AGENCY]);
    }

    public function scopePublic($query)
    {
        return $query->where('role', self::ROLE_PUBLIC);
    }

    public function scopeMcmc($query)
    {
        return $query->where('role', self::ROLE_MCMC);
    }

    public function scopeAgency($query)
    {
        return $query->where('role', self::ROLE_AGENCY);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
