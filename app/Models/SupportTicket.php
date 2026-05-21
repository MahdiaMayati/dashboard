<?php

namespace App\Models;

use App\Enums\SupportTicketPriority;
use App\Enums\SupportTicketStatus;
use Database\Factories\SupportTicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    /** @use HasFactory<SupportTicketFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'related_order_id',
        'assigned_to_user_id',
        'subject',
        'status',
        'priority',
        'opened_by_role',
        'resolved_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => SupportTicketStatus::class,
            'priority' => SupportTicketPriority::class,
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function relatedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'related_order_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class)->orderBy('created_at');
    }
}
