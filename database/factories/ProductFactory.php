<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_category_id' => $this->faker->numberBetween(1,11),
            'name' => $this->faker->unique()->word,
            'scale' => $this->faker->randomElement(['1:18', '1:24', '1:32', '1:43',]),
            'vendor' => $this->faker->word,
            'description' => $this->faker->sentence,
            'quantity_in_stock' => $this->faker->numberBetween(1,200),
            'buy_price' => $this->faker->randomFloat(2,10,200),
            'msrp' => $this->faker->randomFloat(2,10,300),
        ];
    }
}
