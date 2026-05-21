<?php

use App\Enums\ArtisanApprovalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisan_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('specialty_title')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->string('id_proof_path')->nullable();
            $table->string('profession_proof_path')->nullable();
            $table->string('approval_status', 32)->default(ArtisanApprovalStatus::Pending->value);
            $table->text('approval_notes')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_accepting_orders')->default(true);
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->unsignedInteger('completed_orders_count')->default(0);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisan_profiles');
    }
};
