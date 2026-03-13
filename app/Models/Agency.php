<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'contact_email',
        'contact_phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AgencyAssignment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
