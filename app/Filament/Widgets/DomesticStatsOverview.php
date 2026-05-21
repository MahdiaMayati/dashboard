<?php

namespace App\Filament\Widgets;

use App\Enums\ArtisanApprovalStatus;
use App\Enums\ReviewModerationStatus;
use App\Enums\SupportTicketStatus;
use App\Enums\UserRole;
use App\Models\ArtisanProfile;
use App\Models\Order;
use App\Models\Review;
use App\Models\SupportTicket;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DomesticStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Overview';

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $avgRating = Review::query()
            ->where('moderation_status', ReviewModerationStatus::Visible)
            ->avg('rating');

        return [
            Stat::make('Customers', (string) User::query()->customers()->count())
                ->description('Registered customers')
                ->icon('heroicon-o-users'),
            Stat::make('Artisans', (string) User::query()->where('role', UserRole::Artisan)->count())
                ->description('Users with artisan role')
                ->icon('heroicon-o-wrench-screwdriver'),
            Stat::make('Orders', (string) Order::query()->count())
                ->description('All time')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Pending approvals', (string) ArtisanProfile::query()
                ->where('approval_status', ArtisanApprovalStatus::Pending)
                ->count())
                ->description('Artisan registrations')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make('Open tickets', (string) SupportTicket::query()
                ->whereIn('status', [SupportTicketStatus::Open, SupportTicketStatus::Pending])
                ->count())
                ->description('Support workload')
                ->icon('heroicon-o-chat-bubble-left-right'),
            Stat::make('Avg. rating', $avgRating !== null ? number_format((float) $avgRating, 2).' / 5' : '—')
                ->description('Visible reviews')
                ->icon('heroicon-o-star'),
        ];
    }
}
