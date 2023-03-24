<?php

namespace Database\Factories;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'sales_id'=>Sales::factory()->create(),
            'amount_paid'=>$this->faker->randomDigitNotNull(),
            'next_pay_at'=>$this->faker->date
        ];
    }
}
