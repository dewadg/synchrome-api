<?php

namespace App\Transformers;

use App\CalendarEvent;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class CalendarEventTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['attendanceType'];

    /**
     * Transforms the model.
     *
     * @param CalendarEvent $event
     * @return array
     */
    public function transform(CalendarEvent $event)
    {
        return [
            'id' => $event->id,
            'name' => $event->name,
            'start' => $event->start->format('Y-m-d'),
            'end' => ! is_null($event->end) ? $event->end->format('Y-m-d') : null,
        ];
    }

    /**
     * Includes AttendanceType.
     *
     * @param CalendarEvent $event
     * @return Item
     */
    public function includeAttendanceType(CalendarEvent $event)
    {
        $event->load('attendanceType');
        $attendance_type = $event->attendanceType;

        return $this->item($attendance_type, new AttendanceTypeTransformer);
    }
}
