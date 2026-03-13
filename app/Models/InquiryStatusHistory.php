<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'from_status',
        'to_status',
        'notes',
        'officer_name',
        'officer_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->to_status) {
            Inquiry::STATUS_PENDING_REVIEW => 'Pending Review',
            Inquiry::STATUS_UNDER_INVESTIGATION => 'Under Investigation',
            Inquiry::STATUS_VERIFIED_TRUE => 'Verified as True',
            Inquiry::STATUS_IDENTIFIED_FAKE => 'Identified as Fake',
            Inquiry::STATUS_REJECTED => 'Rejected',
            default => ucfirst(str_replace('_', ' ', $this->to_status)),
        };
    }
}
