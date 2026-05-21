<?php

namespace App\Models;

use Database\Factories\AdminNoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNote extends Model
{
    /** @use HasFactory<AdminNoteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_user_id',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
