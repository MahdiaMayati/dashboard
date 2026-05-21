<?php

namespace App\Models;

use App\Enums\ReviewModerationStatus;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'artisan_profile_id',
        'rating',
        'comment',
        'moderation_status',
        'moderated_by_user_id',
        'moderated_at',
    ];

    protected function casts(): array
    {
        return [
            'moderation_status' => ReviewModerationStatus::class,
            'moderated_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function artisanProfile(): BelongsTo
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    public function moderatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by_user_id');
    }
}
