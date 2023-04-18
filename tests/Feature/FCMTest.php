<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FCMTest extends TestCase
{
    use DatabaseTransactions;

    public function testItRegistersFCM()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->postJson(route('register-fcm'), [
            'fcm_token' => 'ABASD',
        ]);

        $this->assertDatabaseHas(User::class, [
            'fcm_token' => 'ABASD',
            'id' => $user->id,
        ]);
    }

    public function testItThrowsAnErrorWhenFCMDeviceTokenIsNotSupplied()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson(route('register-fcm'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['fcm_token']);
    }
}
