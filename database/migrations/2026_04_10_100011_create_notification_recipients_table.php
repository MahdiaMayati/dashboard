<?php

use App\Enums\NotificationDeliveryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('delivery_status', 32)->default(NotificationDeliveryStatus::Pending->value);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['notification_campaign_id', 'user_id'], 'campaign_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_recipients');
    }
};
