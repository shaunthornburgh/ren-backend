<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'sometimes|string|max:50',
            'summary'       => 'sometimes|string|max:250',
            'overview'      => 'sometimes|string',
            'location'      => 'sometimes|string',
            'start'         => 'sometimes|date|after_or_equal:' . now()->toDateString(),
            'end'           => 'sometimes|date|after:start',
            'capacity'      => 'sometimes|integer|min:1',
            'image'         => 'sometimes|image',
            'ticket_price'  => 'nullable|numeric|min:0',
        ];
    }
}
