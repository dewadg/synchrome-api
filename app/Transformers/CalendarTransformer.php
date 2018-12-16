<?php

namespace App\Transformers;

use App\Calendar;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;

class CalendarTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['events'];

    /**
     * Transforms the model.
     *
     * @param Calendar $calendar
     * @return array
     */
    public function transform(Calendar $calendar)
    {
        return [
            'id' => $calendar->id,
            'name' => $calendar->name,
            'start' => $calendar->start->format('Y-m-d'),
            'end' => $calendar->end->format('Y-m-d'),
            'published' => $calendar->published,
        ];
    }

    /**
     * Includes CalendarEvent.
     *
     * @param Calendar $calendar
     * @return Collection
     */
    public function includeEvents(Calendar $calendar)
    {
        $events = $calendar->events;

        return $this->collection($events, new CalendarEventTransformer);
    }
}
