<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'summary'       => $this->summary,
            'overview'      => $this->overview,
            'location'      => $this->location,
            'start'         => $this->start->toIso8601String(),
            'end'           => $this->end->toIso8601String(),
            'capacity'      => $this->capacity,
            'image'         => $this->image,
            'ticket_price'  => $this->ticket_price,
            'created_by'    => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'created_at'    => $this->created_at->toIso8601String(),
            'updated_at'    => $this->updated_at->toIso8601String(),
        ];
    }
}
