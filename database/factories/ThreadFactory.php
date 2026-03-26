<?php

namespace Database\Factories;

use App\Models\Charakter;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'forum_id' => Forum::factory(),
            'charakter_id' => Charakter::factory(),
        ];
    }
}
