<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarEvent>
 */
class CalendarEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventDate = $this->faker->dateTimeBetween('now', '+30 days');
        $dateString = $eventDate->format('Y-m-d');
        $startHour = $this->faker->numberBetween(8, 12);
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i',
            "$dateString $startHour:".str_pad('00', 2, '0', STR_PAD_LEFT)
        );
        $endDateTime = (clone $startDateTime)->addHours($this->faker->numberBetween(1, 6));

        return [
            'title'       => $this->faker->text(50),
            'summary'     => $this->faker->text(250),
            'overview'    => $this->faker->paragraph,
            'location'    => $this->faker->address,
            'start'       => $startDateTime,
            'end'         => $endDateTime,
            'created_by' => User::factory(),
            'capacity'    => $this->faker->numberBetween(1, 100),
            'image'       => $this->faker->imageUrl(640, 480, 'events', true, 'Event'),
        ];
    }
}
