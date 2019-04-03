<?php

use App\Calendar;
use App\CalendarEvent;
use Illuminate\Database\Seeder;

class CalendarsTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'Example Calendar',
            'start' => '2019-01-01',
            'end' => '2019-01-01',
            'published' => true,
            'events' => [
                [
                    'title' => 'New Year 2019',
                    'start' => '2019-01-01',
                    'attendance_type_id' => 'L',
                ],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $data) {
            if (is_null(Calendar::find($data['id']))) {
                $calendar = Calendar::create([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'start' => $data['start'],
                    'end' => $data['end'],
                    'published' => $data['published'],
                ]);

                $events = collect($data['events'])
                    ->map(function ($item) {
                        return new CalendarEvent([
                            'title' => $item['title'],
                            'start' => $item['start'],
                            'attendance_type_id' => $item['attendance_type_id'],
                        ]);
                    });

                $calendar->events()->saveMany($events);
            }
        }
    }
}
