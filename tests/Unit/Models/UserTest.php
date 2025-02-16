<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\CalendarEvent;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can be created with required fields.
     */
    public function test_user_creation_has_required_fields()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->id, 'User ID should not be null');

        $this->assertNotEmpty($user->name, 'User name should not be empty');
        $this->assertNotEmpty($user->email, 'User email should not be empty');

        $this->assertNotEmpty($user->password, 'User password should not be empty');
    }

    /**
     * Test that the email field is unique.
     */
    public function test_user_email_uniqueness()
    {
        $user1 = User::factory()->create();


        $this->expectException(QueryException::class);
        $user2 = User::factory()->make(['email' => $user1->email]);
        $user2->save();
    }

    /**
     * Test the relationship between User and CalendarEvent (eventsCreated).
     */
    public function test_user_eventsCreated_relationship()
    {
        $user = User::factory()->create();

        CalendarEvent::factory()->count(3)->create([
            'created_by' => $user->id,
        ]);

        // Reload the user's eventsCreated relationship.
        $user->load('eventsCreated');

        // Assert that the user has exactly 3 events.
        $this->assertCount(3, $user->eventsCreated);

        // Assert that one of the events matches the expected user.
        $this->assertTrue($user->eventsCreated->contains(function ($event) use ($user) {
            return $event->created_by === $user->id;
        }));
    }
}
