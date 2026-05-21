<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OrderAttachment extends Model
{
    protected $fillable = [
        'order_id',
        'disk',
        'path',
        'original_name',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
