<?php

namespace Database\Factories;

use App\Models\Charakter;
use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'thread_id' => Thread::factory(),
            'user_id' => User::factory(),
            'charakter_id' => Charakter::factory(),
        ];
    }
}
