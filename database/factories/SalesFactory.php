<?php

namespace Database\Factories;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sales::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'trader_name' => $this->faker->name(),
            'trader_phone_number' => $this->faker->phoneNumber(),
            'sales_type' => $this->faker->randomElement(['purchased', 'sold']),
            'created_by' => User::factory()->create(),
        ];
    }
}
