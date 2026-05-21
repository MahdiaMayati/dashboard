<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Seeds the Filament admin user. ADMIN_PASSWORD is required in production.
     * In other environments, if ADMIN_PASSWORD is empty, a random password is generated
     * and printed to the console (never logged to files).
     */
    public function run(): void
    {
        $email = config('app.admin_email');
        $plainPassword = config('app.admin_password');

        if (blank($plainPassword)) {
            if (app()->environment('production')) {
                throw new RuntimeException(
                    'ADMIN_PASSWORD must be set in your .env file in production. Refusing to seed a default admin password.'
                );
            }

            $plainPassword = Str::password(20, true, true, true);

            if ($this->command) {
                $this->command->newLine();
                $this->command->warn('ADMIN_PASSWORD was not set. A random development password was generated.');
                $this->command->line("  Email:    {$email}");
                $this->command->line("  Password: {$plainPassword}");
                $this->command->newLine();
            }
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => Hash::make($plainPassword),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );
    }
}
