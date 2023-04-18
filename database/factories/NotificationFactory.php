<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'App\Notifications\PaymentReminderNotification',
            'data' => json_encode([]),
            'read_at' => null,
        ];
    }
}
