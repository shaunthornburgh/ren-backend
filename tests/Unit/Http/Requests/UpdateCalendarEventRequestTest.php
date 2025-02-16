<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\UpdateCalendarEventRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateCalendarEventRequestTest extends TestCase
{
    public function test_update_calendar_event_request_validation_passes_with_partial_data()
    {
        $data = [
            'title' => 'Updated Event Title',
        ]; // Partial update

        $request = new UpdateCalendarEventRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_update_calendar_event_request_validation_fails_with_invalid_dates()
    {
        $data = [
            'start' => 'invalid-date',
            'end'   => 'invalid-date',
        ];

        $request = new UpdateCalendarEventRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('start', $validator->errors()->toArray());
        $this->assertArrayHasKey('end', $validator->errors()->toArray());
    }
}
