<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\CalendarService;

class RoleServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var [type]
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new CalendarService;
    }

    public function testCreate()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $events = [
            [
                'title' => 'Tahun Baru 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ],
            [
                'title' => 'Natal 2018',
                'start' => '2018-12-25',
                'attendance_type_id' => 'L',
            ],
        ];

        $calendar = $this->service->create($data, $events);

        $this->assertInstanceOf(App\Calendar::class, $calendar);
        $this->assertInstanceOf(App\CalendarEvent::class, $calendar->events->first());
    }

    public function testFind()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $events = [
            [
                'title' => 'Tahun Baru 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ],
            [
                'title' => 'Natal 2018',
                'start' => '2018-12-25',
                'attendance_type_id' => 'L',
            ],
        ];

        $new_calendar = $this->service->create($data, $events);

        $calendar = $this->service->find($new_calendar->id);

        $this->assertInstanceOf(App\Calendar::class, $calendar);
        $this->assertInstanceOf(App\CalendarEvent::class, $calendar->events->first());
    }

    public function testDelete()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $events = [
            [
                'title' => 'Tahun Baru 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ],
            [
                'title' => 'Natal 2018',
                'start' => '2018-12-25',
                'attendance_type_id' => 'L',
            ],
        ];

        $new_calendar = $this->service->create($data, $events);

        $this->assertTrue($this->service->delete($new_calendar->id));
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2017-01-01',
            'end' => '2017-12-31',
            'published' => true,
        ];

        $new_data = [
            'name' => 'Kalender Kerja 2018',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => false,
        ];

        $new_calendar = $this->service->create($data);
        $updated_calendar = $this->service->update($new_calendar->id, $new_data);

        $this->assertTrue($updated_calendar->name === $new_data['name']);
        $this->assertTrue($updated_calendar->start->format('Y-m-d') === $new_data['start']);
        $this->assertTrue($updated_calendar->end->format('Y-m-d') === $new_data['end']);
        $this->assertTrue($updated_calendar->published === $new_data['published']);
    }

    public function testAddEvent()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $new_calendar = $this->service->create($data);

        $updated_calendar = $this->service->addEvent($new_calendar->id, [
            'title' => 'Tahun Baru 2018',
            'start' => '2018-01-01',
            'attendance_type_id' => 'L',
        ]);

        $this->assertTrue($updated_calendar->events->first()->title === 'Tahun Baru 2018');
        $this->assertTrue($updated_calendar->events->first()->start->format('Y-m-d') === '2018-01-01');
        $this->assertTrue($updated_calendar->events->first()->attendance_type_id === 'L');
    }

    public function testUpdateEvent()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $events = [
            [
                'title' => 'Tahun Baru 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ],
        ];

        $new_calendar = $this->service->create($data, $events);
        $updated_calendar = $this->service->updateEvent(
            $new_calendar->id,
            $new_calendar->events->first()->id,
            [
                'title' => 'New Year 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ]
        );

        $this->assertTrue($updated_calendar->events->first()->title === 'New Year 2018');
    }

    public function testDeleteEvent()
    {
        $data = [
            'name' => 'Kalender Kerja 2017',
            'start' => '2018-01-01',
            'end' => '2018-12-31',
            'published' => true,
        ];

        $events = [
            [
                'title' => 'Tahun Baru 2018',
                'start' => '2018-01-01',
                'attendance_type_id' => 'L',
            ],
        ];

        $new_calendar = $this->service->create($data, $events);

        $this->assertTrue($this->service->deleteEvent($new_calendar->id, $new_calendar->events->first()->id));
    }
}
