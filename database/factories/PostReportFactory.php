<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostReportFactory extends Factory
{
    protected $model = PostReport::class;

    public function definition(): array
    {
        return [
            'reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
