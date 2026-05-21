<?php

namespace App\Models;

use App\Enums\NotificationDeliveryStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationRecipient extends Model
{
    protected $fillable = [
        'notification_campaign_id',
        'user_id',
        'delivery_status',
        'delivered_at',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'delivery_status' => NotificationDeliveryStatus::class,
            'delivered_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(NotificationCampaign::class, 'notification_campaign_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
