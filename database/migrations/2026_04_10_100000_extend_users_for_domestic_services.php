<?php

use App\Enums\AccountStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 32)->nullable()->after('email');
            $table->string('account_status', 32)->default(AccountStatus::Active->value)->after('role');
            $table->timestamp('blocked_at')->nullable()->after('account_status');
            $table->timestamp('suspended_at')->nullable()->after('blocked_at');
            $table->timestamp('last_seen_at')->nullable()->after('suspended_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'account_status',
                'blocked_at',
                'suspended_at',
                'last_seen_at',
            ]);
        });
    }
};
