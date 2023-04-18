<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseTransactions;

    private $notificationShape = [
        'data' => [
            'id',
            'data',
            'read_at',
            'created_at',
        ],
    ];

    public function testCanGetAuthenticatedUserAvailableNotifications()
    {
        $notification = Notification::factory()->make(['read_at' => null])->toArray();
        $user = User::factory()->create();
        $user->notifications()->create($notification);

        $response = $this->actingAs($user, 'api')->getJson(route('notifications.index'));

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        $this->notificationShape['data'],
                    ],
                ]
            )
            ->assertJsonCount(1, 'data');
    }

    public function testCanMarkAllUserNotificationsAsRead()
    {
        $notification1 = Notification::factory()->make(['read_at' => null])->toArray();
        $notification2 = Notification::factory()->make(['read_at' => null])->toArray();
        $user = User::factory()->create();
        $user->notifications()->createMany([$notification1, $notification2]);

        $response = $this->actingAs($user, 'api')->postJson(route('mark-all-as-read'));

        $response->assertStatus(200);
        $this->assertEquals(0, $user->fresh()->unreadNotifications->count());
    }

    public function testCanMarkAnIndividualNotificationAsRead()
    {
        $notificationData = Notification::factory()->make(['read_at' => null])->toArray();
        $user = User::factory()->create();
        $user->notifications()->create($notificationData);

        $response = $this->actingAs($user, 'api')->postJson(route('mark-as-read', [
            'notification'=>$user->notifications->first()->id,
        ]));

        $response->assertStatus(200);
        $this->assertNotNull($user->fresh()->notifications->first()->read_at);
    }
}
