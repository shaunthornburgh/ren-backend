<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarEventRequest extends FormRequest
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
            'title'         => 'required|string|max:50',
            'summary'       => 'required|string|max:250',
            'overview'      => 'required|string',
            'location'      => 'required|string',
            'start'         => 'required|date|after_or_equal:' . now()->toDateString(),
            'end'           => 'required|date|after:start',
            'capacity'      => 'required|integer|min:1',
            'image'         => 'nullable|image',
            'ticket_price'  => 'nullable|numeric|min:0',
        ];
    }
}
