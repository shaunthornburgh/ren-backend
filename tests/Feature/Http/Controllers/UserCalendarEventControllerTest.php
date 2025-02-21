<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\CalendarEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCalendarEventControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an authenticated user can view their events via /api/user/events.
     */
    public function test_authenticated_user_can_view_their_events()
    {
        // Create a user.
        $user = User::factory()->create();

        // Create some events for this user.
        CalendarEvent::factory()->count(3)->create([
            'created_by' => $user->id,
        ]);

        // Act as the authenticated user.
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/user/events');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'summary',
                    'overview',
                    'location',
                    'start',
                    'end',
                    'image',
                    'capacity',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $responseData = $response->json();
        $this->assertCount(3, $responseData);
    }

    /**
     * Test that an unauthenticated user cannot access the endpoint.
     */
    public function test_unauthenticated_user_cannot_view_events()
    {
        $response = $this->getJson('/api/user/events');
        $response->assertStatus(401);
    }
}
