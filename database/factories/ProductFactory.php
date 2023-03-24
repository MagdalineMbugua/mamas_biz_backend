<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->randomElement(['intestines', 'liver', 'kidney']),
            'uom' => $this->faker->randomElement(['unit', 'kg', 'litre']),
            'product_type' => $this->faker->randomElement(['meat_product', 'livestock']),
        ];
    }
}
