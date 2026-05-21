<?php

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artisan_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_category_id')->constrained()->restrictOnDelete();
            $table->string('status', 32)->default(OrderStatus::Pending->value);
            $table->string('title')->nullable();
            $table->text('description');
            $table->timestamp('scheduled_at')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('completion_notes')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->text('disputed_reason')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
