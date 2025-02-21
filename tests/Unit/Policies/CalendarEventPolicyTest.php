<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Models\CalendarEvent;
use App\Policies\CalendarEventPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarEventPolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $eventOwner;
    private User $otherUser;
    private CalendarEvent $event;
    private CalendarEventPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        // Create two users: one who owns the event and another who doesn't
        $this->eventOwner = User::factory()->create();
        $this->otherUser = User::factory()->create();

        // Create an event belonging to the first user
        $this->event = CalendarEvent::factory()->create([
            'created_by' => $this->eventOwner->id,
        ]);

        // Initialize the policy
        $this->policy = new CalendarEventPolicy();
    }

    public function test_event_owner_can_update_the_event()
    {
        $this->assertTrue($this->policy->update($this->eventOwner, $this->event));
    }

    public function test_non_owner_cannot_update_the_event()
    {
        $this->assertFalse($this->policy->update($this->otherUser, $this->event));
    }

    public function test_event_owner_can_delete_the_event()
    {
        $this->assertTrue($this->policy->delete($this->eventOwner, $this->event));
    }

    public function test_non_owner_cannot_delete_the_event()
    {
        $this->assertFalse($this->policy->delete($this->otherUser, $this->event));
    }
}
