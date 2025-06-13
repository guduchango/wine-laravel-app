<?php

namespace Database\Factories;

use App\Models\Wine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wine_id' => Wine::factory(),
            'path' => 'wine_photos/' . $this->faker->uuid . '.jpg',
        ];
    }
}
