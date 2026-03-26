<?php

namespace Database\Factories;

use App\Models\Charakter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharakterFactory extends Factory
{
    protected $model = Charakter::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->word(),
            'origin' => $this->faker->word(),
            'race' => $this->faker->word(),
            'eyes' => $this->faker->word(),
            'hair' => $this->faker->word(),
            'biography' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
