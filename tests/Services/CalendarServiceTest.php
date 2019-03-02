<?php

use App\Repositories\AttendanceTypeRepo;
use App\Repositories\CalendarRepo;
use App\Services\CalendarService;
use Carbon\Carbon;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CalendarServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_calendar_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('AttendanceTypesTableSeeder');

        $this->faker = Factory::create();
        $this->test_calendar_service = new CalendarService(new CalendarRepo, new AttendanceTypeRepo);
    }

    public function testGet()
    {
        $mocked_calendar_data = [
            'name' => $this->faker->name,
            'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'end' => Carbon::now()->endOfYear()->format('Y-m-d'),
            'published' => true,
            'events' => [
                [
                    'title' => $this->faker->name,
                    'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
                    'end' => null,
                    'attendance_type_id' => 'L',
                ]
            ],
        ];

        for ($i = 0; $i < 3; $i++) {
            $this->test_calendar_service->create($mocked_calendar_data);
        }

        $calendars = $this->test_calendar_service->get();

        $this->assertCount(3, $calendars);
    }

    public function testCreate()
    {
        $mocked_calendar_data = [
            'name' => $this->faker->name,
            'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'end' => Carbon::now()->endOfYear()->format('Y-m-d'),
            'published' => true,
        ];

        $mocked_events_data = [
            [
                'title' => $this->faker->name,
                'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
                'end' => null,
                'attendance_type_id' => 'L',
            ]
        ];

        $calendar = $this->test_calendar_service->create($mocked_calendar_data, $mocked_events_data);

        $this->assertEquals($mocked_calendar_data['name'], $calendar->name);
        $this->assertEquals($mocked_calendar_data['start'], $calendar->start->format('Y-m-d'));
        $this->assertEquals($mocked_calendar_data['end'], $calendar->end->format('Y-m-d'));
        $this->assertEquals($mocked_calendar_data['published'], $calendar->published);
        $this->assertEquals($mocked_events_data[0]['title'], $calendar->events->first()->title);
        $this->assertEquals($mocked_events_data[0]['start'], $calendar->events->first()->start->format('Y-m-d'));
        $this->assertEquals($mocked_events_data[0]['end'], is_null($calendar->events->first()->end)
            ? $calendar->events->first()->end
            : $calendar->events->first()->end->format('Y-m-d'));
        $this->assertEquals($mocked_events_data[0]['attendance_type_id'], $calendar->events
            ->first()->attendanceType->id);
    }

    public function testUpdate()
    {
        $mocked_calendar_data = [
            'name' => $this->faker->name,
            'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'end' => Carbon::now()->endOfYear()->format('Y-m-d'),
            'published' => true,
        ];

        $mocked_updated_calendar_data = [
            'name' => $this->faker->name . ' 123',
            'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'end' => Carbon::now()->endOfYear()->format('Y-m-d'),
            'published' => false,
        ];

        $mocked_events_data = [
            [
                'title' => $this->faker->name,
                'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
                'end' => null,
                'attendance_type_id' => 'L',
            ]
        ];

        $calendar = $this->test_calendar_service->create($mocked_calendar_data, $mocked_events_data);
        $output = $this->test_calendar_service->update($calendar->id, $mocked_updated_calendar_data);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $mocked_calendar_data = [
            'name' => $this->faker->name,
            'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'end' => Carbon::now()->endOfYear()->format('Y-m-d'),
            'published' => true,
        ];

        $mocked_events_data = [
            [
                'title' => $this->faker->name,
                'start' => Carbon::now()->startOfYear()->format('Y-m-d'),
                'end' => null,
                'attendance_type_id' => 'L',
            ]
        ];

        $calendar = $this->test_calendar_service->create($mocked_calendar_data, $mocked_events_data);
        $output = $this->test_calendar_service->delete($calendar->id);

        $this->assertTrue($output);
    }
}
