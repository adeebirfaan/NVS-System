<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inquiry extends Model
{
    use HasFactory;

    public const STATUS_PENDING_REVIEW = 'pending_review';
    public const STATUS_UNDER_INVESTIGATION = 'under_investigation';
    public const STATUS_VERIFIED_TRUE = 'verified_true';
    public const STATUS_IDENTIFIED_FAKE = 'identified_fake';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING_REVIEW,
        self::STATUS_UNDER_INVESTIGATION,
        self::STATUS_VERIFIED_TRUE,
        self::STATUS_IDENTIFIED_FAKE,
        self::STATUS_REJECTED,
    ];

    public const CATEGORY_NEWS = 'news';
    public const CATEGORY_SOCIAL_MEDIA = 'social_media';
    public const CATEGORY_MESSAGE = 'message';
    public const CATEGORY_VIDEO = 'video';
    public const CATEGORY_IMAGE = 'image';
    public const CATEGORY_OTHER = 'other';

    public const CATEGORIES = [
        self::CATEGORY_NEWS,
        self::CATEGORY_SOCIAL_MEDIA,
        self::CATEGORY_MESSAGE,
        self::CATEGORY_VIDEO,
        self::CATEGORY_IMAGE,
        self::CATEGORY_OTHER,
    ];

    protected $fillable = [
        'user_id',
        'inquiry_number',
        'title',
        'description',
        'category',
        'source_url',
        'content_snippet',
        'status',
        'is_public',
        'mcmc_notes',
        'resolution_notes',
        'submission_ip',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(InquiryEvidences::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(InquiryStatusHistory::class);
    }

    public function latestStatusHistory(): HasOne
    {
        return $this->hasOne(InquiryStatusHistory::class)->latestOfMany();
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(AgencyAssignment::class)->latestOfMany();
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AgencyAssignment::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePendingReview($query)
    {
        return $query->where('status', self::STATUS_PENDING_REVIEW);
    }

    public function scopeUnderInvestigation($query)
    {
        return $query->where('status', self::STATUS_UNDER_INVESTIGATION);
    }

    public function scopeVerified($query)
    {
        return $query->whereIn('status', [self::STATUS_VERIFIED_TRUE, self::STATUS_IDENTIFIED_FAKE]);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAgency($query, int $agencyId)
    {
        return $query->whereHas('assignments', function ($q) use ($agencyId) {
            $q->where('agency_id', $agencyId);
        });
    }

    public function isPendingReview(): bool
    {
        return $this->status === self::STATUS_PENDING_REVIEW;
    }

    public function isUnderInvestigation(): bool
    {
        return $this->status === self::STATUS_UNDER_INVESTIGATION;
    }

    public function isVerified(): bool
    {
        return in_array($this->status, [self::STATUS_VERIFIED_TRUE, self::STATUS_IDENTIFIED_FAKE]);
    }

    public function canViewPublicly(): bool
    {
        return $this->is_public && $this->isVerified();
    }

    public function canUserView(User $user): bool
    {
        if ($user->isMcmc()) {
            return true;
        }

        if ($user->isAgency() && $this->currentAssignment) {
            return $this->currentAssignment->agency_id === $user->agency_id;
        }

        if ($user->isPublic() && $this->user_id === $user->id) {
            return true;
        }

        return $this->canViewPublicly();
    }

    public static function generateInquiryNumber(): string
    {
        $year = date('Y');
        $lastInquiry = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInquiry ? (int) substr($lastInquiry->inquiry_number, -4) + 1 : 1;

        return sprintf('INQ-%s-%04d', $year, $sequence);
    }
}
