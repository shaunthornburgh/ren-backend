<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\CalendarEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CalendarEventControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private CalendarEvent $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        
        $this->event = CalendarEvent::factory()->create([
            'created_by' => $this->user->id,
        ]);
    }

    public function test_it_can_fetch_all_events()
    {
        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'summary', 'overview', 'location', 'start', 'end', 'created_by']
            ]);
    }

    public function test_it_can_fetch_a_single_event()
    {
        $response = $this->getJson("/api/events/{$this->event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $this->event->id,
                'title' => $this->event->title,
            ]);
    }

    public function test_it_requires_authentication_to_create_an_event()
    {
        $response = $this->postJson('/api/events', []);

        $response->assertStatus(401);
    }

    public function test_an_authenticated_user_can_create_an_event()
    {
        Sanctum::actingAs($this->user);

        $eventData = [
            'title'       => $this->faker->sentence,
            'summary'     => $this->faker->text(50),
            'overview'    => $this->faker->paragraph,
            'location'    => $this->faker->address,
            'start'       => now()->addDays(1)->toISOString(),
            'end'         => now()->addDays(1)->addHours(2)->toISOString(),
        ];

        $response = $this->postJson('/api/events', $eventData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Event created successfully',
            ]);

        $this->assertDatabaseHas('calendar_events', [
            'title' => $eventData['title'],
            'summary' => $eventData['summary'],
        ]);
    }

    public function test_it_requires_authentication_to_update_an_event()
    {
        $response = $this->putJson("/api/events/{$this->event->id}", []);

        $response->assertStatus(401);
    }

    public function test_an_authenticated_user_can_update_their_own_event()
    {
        Sanctum::actingAs($this->user);

        $updatedData = [
            'title' => 'Updated Event Title',
        ];

        $response = $this->putJson("/api/events/{$this->event->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Event updated successfully',
            ]);

        $this->assertDatabaseHas('calendar_events', [
            'id' => $this->event->id,
            'title' => 'Updated Event Title',
        ]);
    }

    public function test_a_user_cannot_update_someone_elses_event()
    {
        $anotherUser = User::factory()->create();
        Sanctum::actingAs($anotherUser);

        $response = $this->putJson("/api/events/{$this->event->id}", [
            'title' => 'Unauthorized Update',
        ]);

        $response->assertStatus(403);
    }

    public function test_it_requires_authentication_to_delete_an_event()
    {
        $response = $this->deleteJson("/api/events/{$this->event->id}");

        $response->assertStatus(401);
    }

    public function test_an_authenticated_user_can_delete_their_own_event()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/events/{$this->event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Event deleted successfully',
            ]);

        $this->assertDatabaseMissing('calendar_events', ['id' => $this->event->id]);
    }

    public function test_a_user_cannot_delete_someone_elses_event()
    {
        $anotherUser = User::factory()->create();
        Sanctum::actingAs($anotherUser);

        $response = $this->deleteJson("/api/events/{$this->event->id}");

        $response->assertStatus(403);
    }
}
