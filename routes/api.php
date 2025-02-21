<?php

use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\UserCalendarEventController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user());
})->middleware('auth:sanctum');

Route::get('/events', [CalendarEventController::class, 'index']);
Route::get('/events/{event}', [CalendarEventController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/events', [CalendarEventController::class, 'store']);
    Route::put('/events/{event}', [CalendarEventController::class, 'update']);
    Route::delete('/events/{event}', [CalendarEventController::class, 'destroy']);
    Route::get('/user/events', [UserCalendarEventController::class, 'index']);
});
