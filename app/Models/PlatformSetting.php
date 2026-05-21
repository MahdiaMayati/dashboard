<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'support_email',
        'business_phone',
        'announcement',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            [
                'support_email' => config('mail.from.address'),
                'business_phone' => null,
                'announcement' => null,
            ]
        );
    }
}
