<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'phone',
    'account_status',
    'blocked_at',
    'suspended_at',
    'last_seen_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens , HasFactory,Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'account_status' => AccountStatus::class,
            'blocked_at' => 'datetime',
            'suspended_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() !== 'admin') {
            return false;
        }

        return in_array($this->role, [UserRole::Admin, UserRole::Support], true);
    }

    public function artisanProfile(): HasOne
    {
        return $this->hasOne(ArtisanProfile::class);
    }

    public function ordersAsCustomer(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function supportTicketsAssigned(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to_user_id');
    }

    public function adminNotesAbout(): HasMany
    {
        return $this->hasMany(AdminNote::class, 'user_id');
    }

    public function adminNotesAuthored(): HasMany
    {
        return $this->hasMany(AdminNote::class, 'admin_user_id');
    }

    public function notificationCampaignsCreated(): HasMany
    {
        return $this->hasMany(NotificationCampaign::class, 'created_by_user_id');
    }

    public function scopeCustomers(Builder $query): Builder
    {
        return $query->where('role', UserRole::Customer);
    }

    public function scopeArtisans(Builder $query): Builder
    {
        return $query->where('role', UserRole::Artisan);
    }

    public function scopeStaff(Builder $query): Builder
    {
        return $query->whereIn('role', [UserRole::Admin, UserRole::Support]);
    }
}
