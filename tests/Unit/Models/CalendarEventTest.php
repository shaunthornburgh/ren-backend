<?php

namespace Tests\Unit\Models;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CalendarEventTest extends TestCase
{
    use RefreshDatabase;


    public function test_calendar_events_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('calendar_events', [
                'id',
                'title',
                'summary',
                'overview',
                'location',
                'start',
                'end',
                'created_by',
                'created_at',
                'updated_at'
        ]));
    }

    public function test_it_belongs_to_a_creator()
    {
        $calendarEvent = CalendarEvent::factory()->create();

        $this->assertEquals(1, $calendarEvent->creator()->count());
        $this->assertInstanceOf(User::class, $calendarEvent->creator);
    }
}
