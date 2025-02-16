<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreCalendarEventRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreCalendarEventRequestTest extends TestCase
{
    public function test_store_calendar_event_request_validation_passes_with_valid_data()
    {
        $data = [
            'title'     => 'Laravel Meetup',
            'summary'   => 'A meetup for Laravel developers.',
            'overview'  => 'This is an event about Laravel and networking.',
            'location'  => 'Medellín, Colombia',
            'start'     => now()->addDay()->toISOString(),
            'end'       => now()->addDays(2)->toISOString(),
        ];

        $request = new StoreCalendarEventRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_store_calendar_event_request_validation_fails_with_missing_fields()
    {
        $data = []; // Empty data

        $request = new StoreCalendarEventRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
        $this->assertArrayHasKey('summary', $validator->errors()->toArray());
        $this->assertArrayHasKey('start', $validator->errors()->toArray());
        $this->assertArrayHasKey('end', $validator->errors()->toArray());
    }

    public function test_store_calendar_event_request_validation_fails_with_invalid_dates()
    {
        $data = [
            'title'     => 'VueJS Meetup',
            'summary'   => 'VueJS event',
            'overview'  => 'An event for VueJS developers.',
            'location'  => 'Bogotá, Colombia',
            'start'     => 'invalid-date', // Invalid date format
            'end'       => 'invalid-date',
        ];

        $request = new StoreCalendarEventRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('start', $validator->errors()->toArray());
        $this->assertArrayHasKey('end', $validator->errors()->toArray());
    }
}
