<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(
        ?int $userId,
        string $action,
        string $entityType,
        ?int $entityId = null,
        array $oldValues = [],
        array $newValues = [],
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    public static function logInquiry(int $userId, string $action, Inquiry $inquiry, ?string $ipAddress = null): void
    {
        self::log(
            $userId,
            $action,
            'inquiry',
            $inquiry->id,
            [],
            $inquiry->toArray(),
            $ipAddress
        );
    }

    public static function logStatusChange(
        int $userId,
        Inquiry $inquiry,
        string $fromStatus,
        string $toStatus,
        ?string $notes = null,
        ?string $ipAddress = null
    ): void
    {
        self::log(
            $userId,
            'status_changed',
            'inquiry',
            $inquiry->id,
            ['status' => $fromStatus],
            ['status' => $toStatus, 'notes' => $notes],
            $ipAddress
        );
    }

    public static function logAgencyAssignment(
        int $userId,
        Inquiry $inquiry,
        Agency $agency,
        ?string $ipAddress = null
    ): void
    {
        self::log(
            $userId,
            'assigned_to_agency',
            'inquiry',
            $inquiry->id,
            [],
            ['agency_id' => $agency->id, 'agency_name' => $agency->name],
            $ipAddress
        );
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'status_changed' => 'Status Changed',
            'assigned_to_agency' => 'Assigned to Agency',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            default => ucfirst($this->action),
        };
    }
}
