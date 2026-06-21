<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CharacterSeeder::class,
            ForumSeeder::class,
            GameplaySeeder::class,
            ContentSeeder::class,
        ]);
    }
}
