<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'from_status',
        'to_status',
        'changed_by_user_id',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (OrderStatusLog $log): void {
            if ($log->created_at === null) {
                $log->created_at = now();
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }

    public function getFromStatusEnumAttribute(): ?OrderStatus
    {
        return $this->from_status !== null ? OrderStatus::tryFrom($this->from_status) : null;
    }

    public function getToStatusEnumAttribute(): ?OrderStatus
    {
        return OrderStatus::tryFrom($this->to_status);
    }
}
