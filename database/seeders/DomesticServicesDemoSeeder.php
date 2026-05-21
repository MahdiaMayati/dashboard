<?php

namespace Database\Seeders;

use App\Enums\ArtisanApprovalStatus;
use App\Enums\OrderStatus;
use App\Enums\SupportTicketStatus;
use App\Enums\UserRole;
use App\Models\ArtisanProfile;
use App\Models\Order;
use App\Models\PlatformSetting;
use App\Models\Review;
use App\Models\ServiceCategory;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Enums\ReviewModerationStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class DomesticServicesDemoSeeder extends Seeder
{
    public function run(): void
    {
        PlatformSetting::current();

        $categories = collect([
            ['name' => 'Plumbing', 'slug' => 'plumbing', 'sort_order' => 1],
            ['name' => 'Electrical', 'slug' => 'electrical', 'sort_order' => 2],
            ['name' => 'Carpentry', 'slug' => 'carpentry', 'sort_order' => 3],
            ['name' => 'Painting', 'slug' => 'painting', 'sort_order' => 4],
            ['name' => 'Cleaning', 'slug' => 'cleaning', 'sort_order' => 5],
        ])->map(fn (array $row) => ServiceCategory::query()->firstOrCreate(
            ['slug' => $row['slug']],
            [
                'name' => $row['name'],
                'description' => fake()->sentence(10),
                'is_active' => true,
                'sort_order' => $row['sort_order'],
            ]
        ));

        $customers = User::factory()
            ->count(12)
            ->state(['role' => UserRole::Customer])
            ->create();

        $pendingArtisans = ArtisanProfile::factory()
            ->count(3)
            ->pending()
            ->create();

        $approvedArtisans = ArtisanProfile::factory()
            ->count(8)
            ->create();

        foreach ($approvedArtisans as $profile) {
            $profile->serviceCategories()->sync(
                $categories->random(rand(1, 3))->pluck('id')->all()
            );
        }

        $orders = collect();
        foreach (range(1, 35) as $i) {
            $status = fake()->randomElement(OrderStatus::cases());
            $customer = $customers->random();
            $artisan = $approvedArtisans->random();

            $order = Order::factory()
                ->state([
                    'customer_id' => $customer->id,
                    'artisan_profile_id' => $artisan->id,
                    'service_category_id' => $categories->random()->id,
                    'status' => $status,
                    'completed_at' => $status === OrderStatus::Completed ? now()->subDays(rand(1, 60)) : null,
                    'cancelled_at' => $status === OrderStatus::Cancelled ? now()->subDays(rand(1, 20)) : null,
                ])
                ->create();
            $orders->push($order);
        }

        foreach ($orders->random(min(15, $orders->count())) as $order) {
            if ($order->status !== OrderStatus::Completed) {
                continue;
            }
            if (Review::query()->where('order_id', $order->id)->exists()) {
                continue;
            }
            Review::factory()
                ->state([
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'artisan_profile_id' => $order->artisan_profile_id,
                ])
                ->create();
        }

        foreach (range(1, 8) as $i) {
            $user = fake()->boolean(70) ? $customers->random() : User::factory()->create(['role' => UserRole::Customer]);
            $ticket = SupportTicket::factory()
                ->state([
                    'user_id' => $user->id,
                    'status' => fake()->randomElement([
                        SupportTicketStatus::Open,
                        SupportTicketStatus::Pending,
                        SupportTicketStatus::Resolved,
                    ]),
                ])
                ->create();

            SupportMessage::factory()
                ->count(rand(1, 4))
                ->state(['support_ticket_id' => $ticket->id, 'sender_user_id' => $user->id])
                ->create();
        }

        // Recalculate average ratings for artisans with reviews
        foreach ($approvedArtisans as $profile) {
            $avg = Review::query()
                ->where('artisan_profile_id', $profile->id)
                ->where('moderation_status', ReviewModerationStatus::Visible)
                ->avg('rating');
            if ($avg !== null) {
                $profile->update(['average_rating' => round((float) $avg, 2)]);
            }
        }

        // Ensure at least one pending artisan for dashboard KPIs
        if ($pendingArtisans->isEmpty()) {
            ArtisanProfile::factory()->pending()->create();
        }
    }
}
