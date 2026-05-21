<?php

namespace App\Models;

use App\Enums\ArtisanApprovalStatus;
use Database\Factories\ArtisanProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtisanProfile extends Model
{
    /** @use HasFactory<ArtisanProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_title',
        'bio',
        'latitude',
        'longitude',
        'address',
        'profile_image_path',
        'id_proof_path',
        'profession_proof_path',
        'approval_status',
        'approval_notes',
        'is_available',
        'is_accepting_orders',
        'average_rating',
        'completed_orders_count',
    ];

    protected function casts(): array
    {
        return [
            'approval_status' => ArtisanApprovalStatus::class,
            'is_available' => 'boolean',
            'is_accepting_orders' => 'boolean',
            'average_rating' => 'decimal:2',
            'completed_orders_count' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function serviceCategories(): BelongsToMany
    {
        return $this->belongsToMany(ServiceCategory::class, 'artisan_profile_service_category')
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
