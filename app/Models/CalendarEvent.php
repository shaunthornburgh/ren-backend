<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'overview',
        'location',
        'start',
        'end',
        'created_by',
        'capacity',
        'image',
        'ticket_price'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end'   => 'datetime',
        'capacity' => 'integer',
        'ticket_price' => 'float',
    ];

    /**
     * Get the user that created this event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
