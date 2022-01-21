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
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'type' => $this->faker->randomElement(['purchased', 'sold']),
            'status' => $this->faker->randomElement(['not_paid', 'not_fully_paid', 'paid']),
            'created_by' => User::factory()->create(),
            'pay_at' => $this->faker->date(),

        ];
    }
}
