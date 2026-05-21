<?php

use App\Enums\NotificationCampaignStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('audience_type', 32);
            $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 32)->default(NotificationCampaignStatus::Draft->value);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_campaigns');
    }
};
