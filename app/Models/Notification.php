<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    public const TYPE_INQUIRY_SUBMITTED = 'inquiry_submitted';
    public const TYPE_INQUIRY_ASSIGNED = 'inquiry_assigned';
    public const TYPE_INQUIRY_ACCEPTED = 'inquiry_accepted';
    public const TYPE_INQUIRY_REJECTED = 'inquiry_rejected';
    public const TYPE_STATUS_UPDATED = 'status_updated';
    public const TYPE_INQUIRY_COMPLETED = 'inquiry_completed';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public static function createForUser(
        int $userId,
        string $type,
        string $title,
        string $message,
        array $data = []
    ): self {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function notifyMCMC(string $type, string $title, string $message, array $data = []): void
    {
        $mcmcUsers = User::mcmc()->active()->get();
        
        foreach ($mcmcUsers as $user) {
            self::createForUser($user->id, $type, $title, $message, $data);
        }
    }

    public static function notifyAgency(int $agencyId, string $type, string $title, string $message, array $data = []): void
    {
        $agencyUsers = User::where('agency_id', $agencyId)->active()->get();
        
        foreach ($agencyUsers as $user) {
            self::createForUser($user->id, $type, $title, $message, $data);
        }
    }
}
