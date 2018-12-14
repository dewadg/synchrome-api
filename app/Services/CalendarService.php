<?php

namespace App\Services;

use App\Calendar;
use App\CalendarEvent;
use App\Repositories\AttendanceTypeRepo;
use App\Repositories\CalendarRepo;
use Illuminate\Support\Collection;

class CalendarService
{
    /**
     * @var CalendarRepo
     */
    protected $repo;

    /**
     * @var AttendanceTypeRepo
     */
    protected $attendance_type_repo;

    /**
     * CalendarService constructor.
     */
    public function __construct()
    {
        $this->repo = new CalendarRepo;
        $this->attendance_type_repo = new AttendanceTypeRepo;
    }

    /**
     * Creates new calendar.
     *
     * @param array $data
     * @param array $events
     * @return Calendar
     */
    public function create(array $data, array $events = [])
    {
        $calendar = Calendar::create([
            'name' => $data['name'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        $events_data = collect($events)
            ->map(function ($item) {
                return new CalendarEvent([
                    'name' => $item['name'],
                    'start' => $item['start'],
                    'end' => ! isset($item['end']) ? null : $item['end'],
                    'attendance_type_id' => $item['attendance_type_id'],
                ]);
            })
            ->all();

        $calendar->events()->saveMany($events_data);
        $calendar->load('events');

        return $calendar;
    }

    /**
     * Updates a calendar.
     *
     * @param $id
     * @param array $data
     * @return Calendar
     */
    public function update($id, array $data)
    {
        $calendar = $this->repo->find($id);

        $calendar->update([
            'name' => $data['name'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        return $calendar;
    }

    /**
     * Returns new calendar by ID.
     *
     * @param $id
     * @return Calendar
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Deletes calendar by ID.
     *
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    /**
     * Returns events of a calendar.
     *
     * @param $id
     * @return Collection
     */
    public function getEvents($id)
    {
        $calendar = $this->repo->find($id);

        return $calendar->events;
    }

    /**
     * Add an event to a calendar.
     *
     * @param $id
     * @param array $event
     * @return Calendar
     */
    public function addEvent($id, array $event)
    {
        $calendar = $this->repo->find($id);

        $calendar->events()->create([
            'name' => $event['name'],
            'start' => $event['start'],
            'end' => ! isset($event['end']) ? null : $event['end'],
            'attendance_type_id' => $event['attendance_type_id'],
        ]);

        $calendar->load('events');

        return $calendar;
    }

    /**
     * Updates an event.
     *
     * @param $calendar_id
     * @param  $event_id
     * @param array $data
     * @return Calendar
     */
    public function updateEvent($calendar_id, $event_id, array $data)
    {
        $calendar = $this->repo->find($calendar_id);
        $event = $calendar->events()->find($event_id);

        $event->update([
            'name' => $data['name'],
            'start' => $data['start'],
            'end' => ! isset($data['end']) ? null : $data['end'],
            'attendance_type_id' => $data['attendance_type_id'],
        ]);

        $calendar->load('events');

        return $calendar;
    }

    /**
     * Deletes an event.
     *
     * @param $calendar_id
     * @param $event_id
     * @return boolean
     */
    public function deleteEvent($calendar_id, $event_id)
    {
        return CalendarEvent::where([
            'id' => $event_id,
            'calendar_id' => $calendar_id,
        ])->delete() === 1 ? true : false;
    }
}
