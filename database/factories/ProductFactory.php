<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 4),
            'name' => $this->faker->name,
            'description' => $this->faker->text(200),
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(5000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->boolean,
            'is_favorite' => $this->faker->boolean,
        ];
    }
}
