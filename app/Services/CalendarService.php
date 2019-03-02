<?php

namespace App\Services;

use App\Calendar;
use App\CalendarEvent;
use App\Repositories\AttendanceTypeRepo;
use App\Repositories\CalendarRepo;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CalendarService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * @var RepositoryInterface
     */
    protected $attendance_type_repo;

    /**
     * CalendarService constructor.
     */
    public function __construct(CalendarRepo $repo, AttendanceTypeRepo $attendance_type_repo)
    {
        $this->repo = $repo;
        $this->attendance_type_repo = $attendance_type_repo;
    }

    /**
     * Returns all calendars.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
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
            'published' => $data['published'],
        ]);

        $events_data = collect($events)
            ->map(function ($item) {
                return new CalendarEvent([
                    'title' => $item['title'],
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
     * @return boolean
     */
    public function update($id, array $data)
    {
        $calendar = $this->repo->find($id);

        return $calendar->update([
            'name' => $data['name'],
            'start' => $data['start'],
            'end' => $data['end'],
            'published' => $data['published'],
        ]);
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
     */
    public function addEvent($id, array $event)
    {
        $calendar = $this->repo->find($id);

        $calendar->events()->create([
            'title' => $event['title'],
            'start' => $event['start'],
            'end' => ! isset($event['end']) ? null : $event['end'],
            'attendance_type_id' => $event['attendance_type_id'],
        ]);
    }

    /**
     * Updates an event.
     *
     * @param $calendar_id
     * @param  $event_id
     * @param array $data
     * @return boolean
     * @throws ModelNotFoundException
     */
    public function updateEvent($calendar_id, $event_id, array $data)
    {
        $calendar = $this->repo->find($calendar_id);
        $event = $calendar->events()->find($event_id);

        if (is_null($event)) {
            throw new ModelNotFoundException;
        }

        $event->update([
            'title' => $data['title'],
            'start' => $data['start'],
            'end' => ! isset($data['end']) ? null : $data['end'],
            'attendance_type_id' => $data['attendance_type_id'],
        ]);
    }

    /**
     * Deletes an event.
     *
     * @param $calendar_id
     * @param $event_id
     * @return boolean
     * @throws ModelNotFoundException
     */
    public function deleteEvent($calendar_id, $event_id)
    {
        $event = CalendarEvent::where([
            'id' => $event_id,
            'calendar_id' => $calendar_id,
        ])->first();

        if (is_null($event)) {
            throw new ModelNotFoundException;
        }

        return $event->delete();
    }
}
