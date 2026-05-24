<?php

namespace Database\Factories;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharakterSheetFactory extends Factory
{
    protected $model = CharakterSheet::class;

    public function definition(): array
    {
        return [
            'statistic' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'charakter_id' => Charakter::factory(),
        ];
    }
}
