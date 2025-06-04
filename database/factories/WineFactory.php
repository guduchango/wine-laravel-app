<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'winery' => $this->faker->company,
            'variety' => $this->faker->word,
            'vintage' => $this->faker->year,
            'country' => $this->faker->country,
        ];
    }
}
