<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class UserCalendarEventController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all the user's events.
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        Log::error('test');
        $events = CalendarEvent::where('created_by', auth()->id())->latest()->get();

        return CalendarEventResource::collection($events);
    }
}
