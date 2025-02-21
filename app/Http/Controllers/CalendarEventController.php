<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendarEventRequest;
use App\Http\Requests\UpdateCalendarEventRequest;
use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all events.
     */
    public function index(): AnonymousResourceCollection
    {
        return CalendarEventResource::collection(CalendarEvent::latest()->get());
    }

    /**
     * Display a specific event.
     */
    public function show(CalendarEvent $event)
    {
        return new CalendarEventResource($event);
    }

    /**
     * Store a newly created event.
     */
    public function store(StoreCalendarEventRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $data['created_by'] = auth()->id();

        $event = CalendarEvent::create($data);

        return response()->json([
            'message' => 'Event created successfully',
            'data' => new CalendarEventResource($event)
        ], 201);
    }

    /**
     * Update an existing event.
     */
    public function update(UpdateCalendarEventRequest $request, CalendarEvent $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return response()->json([
            'message' => 'Event updated successfully',
            'event'   => new CalendarEventResource($event),
        ], 200);
    }

    /**
     * Remove an event from storage.
     */
    public function destroy(CalendarEvent $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
