<?php

namespace App\Models;

use App\Enums\NotificationAudienceType;
use App\Enums\NotificationCampaignStatus;
use Database\Factories\NotificationCampaignFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationCampaign extends Model
{
    /** @use HasFactory<NotificationCampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'created_by_user_id',
        'title',
        'body',
        'audience_type',
        'target_user_id',
        'status',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'audience_type' => NotificationAudienceType::class,
            'status' => NotificationCampaignStatus::class,
            'sent_at' => 'datetime',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class);
    }
}
