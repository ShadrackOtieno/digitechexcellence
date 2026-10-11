<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Change these in .env (ADMIN_EMAIL / ADMIN_PASSWORD) before seeding, or from Admin > Account afterwards.
        $email = env('ADMIN_EMAIL', 'admin@devadvantage.test');
        $password = env('ADMIN_PASSWORD', 'ChangeMe-2026!');

        User::updateOrCreate(
            ['email' => $email],
            ['name' => 'DevAdvantage Admin', 'password' => $password, 'is_admin' => true]
        );
    }
}
