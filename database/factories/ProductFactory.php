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
            'product_name' => $this->faker->word,
            'product_sku' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'product_price' => $this->faker->randomFloat(2, 10, 1000),
            'product_stock' => $this->faker->numberBetween(0, 100),
            'product_image' => $this->faker->imageUrl(400, 400, 'products', true),
            'product_category' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
