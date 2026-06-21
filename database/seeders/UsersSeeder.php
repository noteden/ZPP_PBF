<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $accounts = [
            // Główne konta testowe.
            ['name' => 'Admin',           'email' => 'admin@test.com', 'role' => UserRole::Admin,  'online' => true],
            ['name' => 'Użytkownik',      'email' => 'user@test.com',  'role' => UserRole::Player, 'online' => true],

            ['name' => 'Administrator',   'email' => 'admin@test.com', 'role' => UserRole::Admin,      'online' => true],
            ['name' => 'Mistrz Gry',      'email' => 'mg@test.com',    'role' => UserRole::GameMaster, 'online' => true],
            ['name' => 'Aldric Cierń',    'email' => 'aldric@test.com'],
            ['name' => 'Lyra Świtczyca',  'email' => 'lyra@test.com',  'online' => true],
            ['name' => 'Borin Kamienna Pięść', 'email' => 'borin@test.com'],
            ['name' => 'Seraphina Mrok',  'email' => 'seraphina@test.com'],
            ['name' => 'Garrick Wilczy',  'email' => 'garrick@test.com', 'online' => true],
            ['name' => 'Mira Ziołoznawczyni', 'email' => 'mira@test.com'],
            ['name' => 'Theron Płomień',  'email' => 'theron@test.com'],
            ['name' => 'Niezatwierdzony Nowicjusz', 'email' => 'nowy@test.com', 'approved' => false],
        ];

        foreach ($accounts as $i => $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name'              => $account['name'],
                    'password'          => $password,
                    'role'              => $account['role'] ?? UserRole::Player,
                    'approved'          => $account['approved'] ?? true,
                    'email_verified_at' => now(),
                    'last_seen_at'      => ($account['online'] ?? false)
                        ? now()->subMinute()
                        : now()->subDays($i + 1),
                ]
            );
        }
    }
}
