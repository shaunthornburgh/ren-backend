<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarEventResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_event_resource_formats_data_correctly()
    {
        $user = User::factory()->create();
        $event = CalendarEvent::factory()->create([
            'created_by' => $user->id,
        ]);

        $resource = new CalendarEventResource($event);
        $response = $resource->toArray(request());

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('title', $response);
        $this->assertArrayHasKey('summary', $response);
        $this->assertArrayHasKey('overview', $response);
        $this->assertArrayHasKey('location', $response);
        $this->assertArrayHasKey('start', $response);
        $this->assertArrayHasKey('end', $response);
        $this->assertArrayHasKey('capacity', $response);
        $this->assertArrayHasKey('image', $response);
        $this->assertArrayHasKey('created_by', $response);
        $this->assertArrayHasKey('created_at', $response);
        $this->assertArrayHasKey('updated_at', $response);

        $this->assertEquals($event->id, $response['id']);
        $this->assertEquals($event->title, $response['title']);
        $this->assertEquals($event->summary, $response['summary']);
        $this->assertEquals($event->location, $response['location']);
        $this->assertEquals($event->start->toIso8601String(), $response['start']);
        $this->assertEquals($event->end->toIso8601String(), $response['end']);
        $this->assertEquals($event->capacity, $response['capacity']);
        $this->assertEquals($event->image, $response['image']);
        $this->assertEquals($user->id, $response['created_by']['id']);
        $this->assertEquals($user->name, $response['created_by']['name']);
    }
}
