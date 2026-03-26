<?php

namespace Database\Factories;

use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PrivateMessageFactory extends Factory
{
    protected $model = PrivateMessage::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word(),
            'is_read' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'sender_user_id' => User::factory(),
            'receiver_user_id' => User::factory(),
        ];
    }
}
