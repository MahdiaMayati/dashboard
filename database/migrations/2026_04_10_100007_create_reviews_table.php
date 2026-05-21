<?php

use App\Enums\ReviewModerationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artisan_profile_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('moderation_status', 32)->default(ReviewModerationStatus::Visible->value);
            $table->foreignId('moderated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();

            $table->unique('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
