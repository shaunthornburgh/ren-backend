<?php

namespace Database\Seeders;

use App\Models\CalendarEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CalendarEventSeeder extends Seeder
{
    public function run()
    {
        $user = User::first() ?? User::factory()->create();

        $events = [
            [
                'title'       => 'Tech Networking Night',
                'date'        => 'January 15, 2025',
                'time'        => '3:00 PM',
                'description' => 'Join us for an evening of networking with industry leaders in tech.',
                'location'    => 'Downtown Conference Center',
                'image'       => 'https://images.unsplash.com/photo-1515168833906-d2a3b82b302a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 150,
                'ticket_price'=> 20.00, // Add ticket price here
                'hostedBy'    => 'Plymouth Business Networking Group',
            ],
            [
                'title'       => 'Startup Pitch Fest',
                'date'        => 'February 5, 2025',
                'time'        => '6:00 PM',
                'description' => 'Witness innovative startup pitches and meet potential collaborators.',
                'location'    => 'Tech Hub Auditorium',
                'image'       => 'https://images.unsplash.com/photo-1520110120835-c96534a4c984?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 200,
                'ticket_price'=> 0.00, // Free event
                'hostedBy'    => 'Exeter BNI',
            ],
            [
                'title'       => 'Annual Marketing Summit',
                'date'        => 'March 10, 2025',
                'time'        => '10:00 AM',
                'description' => 'Expand your marketing skills with workshops and keynote speeches.',
                'location'    => 'Grand Event Center',
                'image'       => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 300,
                'ticket_price'=> 50.00, // Paid event
            ],
            [
                'title'       => 'Healthcare Innovation Forum',
                'date'        => 'April 20, 2025',
                'time'        => '9:00 AM',
                'description' => 'Explore groundbreaking innovations in the healthcare industry.',
                'location'    => 'City Convention Hall',
                'image'       => 'https://images.unsplash.com/photo-1531058020387-3be344556be6?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 250,
                'ticket_price'=> 30.00, // Paid event
            ],
            [
                'title'       => 'Artificial Intelligence Expo',
                'date'        => 'May 5, 2025',
                'time'        => '2:00 PM',
                'description' => 'Dive into the latest advancements in AI technology.',
                'location'    => 'Tech Pavilion',
                'image'       => 'https://images.unsplash.com/photo-1523908511403-7fc7b25592f4?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 400,
                'ticket_price'=> 40.00, // Paid event
            ],
            [
                'title'       => 'Sustainability and Green Tech Conference',
                'date'        => 'June 15, 2025',
                'time'        => '11:00 AM',
                'description' => 'Discover how green tech is shaping the future.',
                'location'    => 'EcoHub Arena',
                'image'       => 'https://images.unsplash.com/photo-1560523160-754a9e25c68f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 180,
                'ticket_price'=> 25.00, // Paid event
            ],
            [
                'title'       => 'Leadership Development Workshop',
                'date'        => 'July 10, 2025',
                'time'        => '8:00 AM',
                'description' => 'Enhance your leadership skills with expert guidance.',
                'location'    => 'Downtown Leadership Center',
                'image'       => 'https://images.unsplash.com/photo-1576085898274-069be5a26c58?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 120,
                'ticket_price'=> 60.00, // Paid event
            ],
            [
                'title'       => 'Entrepreneurial Bootcamp',
                'date'        => 'August 25, 2025',
                'time'        => '5:00 PM',
                'description' => 'Turn your business ideas into reality with this hands-on bootcamp.',
                'location'    => 'Startup Academy',
                'image'       => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=590&q=80',
                'capacity'    => 75,
                'ticket_price'=> 100.00, // Paid event
            ],
        ];

        foreach ($events as $event) {
            $start = Carbon::parse("{$event['date']} {$event['time']}");
            $end = (clone $start)->addHours(2);

            CalendarEvent::create([
                'title'       => $event['title'],
                'summary'     => substr($event['description'], 0, 100),
                'overview'    => $event['description'],
                'location'    => $event['location'],
                'start'       => $start->toDateTimeString(),
                'end'         => $end->toDateTimeString(),
                'capacity'    => $event['capacity'],
                'image'       => $event['image'],
                'ticket_price'=> $event['ticket_price'],
                'created_by'  => $user->id,
            ]);
        }
    }
}
