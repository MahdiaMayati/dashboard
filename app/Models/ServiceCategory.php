<?php

namespace App\Models;

use Database\Factories\ServiceCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    /** @use HasFactory<ServiceCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ServiceCategory $category): void {
            if (blank($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function artisanProfiles(): BelongsToMany
    {
        return $this->belongsToMany(ArtisanProfile::class, 'artisan_profile_service_category')
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
