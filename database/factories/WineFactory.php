<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['animal', 'vaca','perro','lobo','elefante','casa','auto']),
            'variety' => $this->faker->randomElement(['malbec', 'cabernet sauvignon', 'bonarda','syrah','tempranillo','merlot','petit verdot','pinot noir','torrontes','chardonnay','sauvignon blanc']),
            'vintage' => $this->faker->numberBetween(2020, 2025),
            'alcohol' => $this->faker->randomFloat(1, 11, 16),
            'price' => $this->faker->numberBetween(3000, 50000),
            'color' => $this->faker->randomElement(['translucent', 'medium', 'deep']),
            'aroma' => $this->faker->randomElement(['low', 'medium', 'intense']),
            'sweetness' => $this->faker->randomElement(['dry', 'semi-dry,', 'sweet']),
            'acidity' => $this->faker->randomElement(['low', 'medium', 'high']),
            'tannin' => $this->faker->randomElement(['mild', 'medium,', 'antringent']),
            'body' => $this->faker->randomElement(['light', 'medium,', 'robust']),
            'persistence' => $this->faker->randomElement(['short', 'medium,', 'long']),
            'tasted_day' => $this->faker->date(),
            'score' => $this->faker->randomElement(
                [
                    'special gathering',
                    'get-together with close friends',
                    'hangout with friends',
                    'it\'s tasty, but expensive',
                    'I wouldn\'t buy it'
                ]),

        ];
    }
}
