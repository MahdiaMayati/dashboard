<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisan_profile_service_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artisan_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['artisan_profile_id', 'service_category_id'], 'artisan_category_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisan_profile_service_category');
    }
};
