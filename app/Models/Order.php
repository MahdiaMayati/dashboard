<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'artisan_profile_id',
        'service_category_id',
        'status',
        'title',
        'description',
        'scheduled_at',
        'address',
        'latitude',
        'longitude',
        'completion_notes',
        'cancelled_reason',
        'disputed_reason',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Order $order): void {
            OrderStatusLog::query()->create([
                'order_id' => $order->id,
                'from_status' => null,
                'to_status' => $order->status->value,
                'changed_by_user_id' => null,
                'note' => 'Order created.',
            ]);
        });

        static::updated(function (Order $order): void {
            if (! $order->wasChanged('status')) {
                return;
            }

            OrderStatusLog::query()->create([
                'order_id' => $order->id,
                'from_status' => OrderStatus::tryFrom($order->getOriginal('status'))?->value
                    ?? $order->getOriginal('status'),
                'to_status' => $order->status->value,
                'changed_by_user_id' => auth()->id(),
                'note' => null,
            ]);
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function artisanProfile(): BelongsTo
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->orderByDesc('created_at');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(OrderAttachment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
