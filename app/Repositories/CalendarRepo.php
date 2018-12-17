<?php

namespace App\Repositories;

use App\Calendar;

class CalendarRepo implements RepositoryInterface
{
    public function get()
    {
        return Calendar::with(['events', 'events.attendanceType'])
            ->get([
                'id',
                'name',
                'start',
                'end',
                'published',
            ]);
    }

    public function find($id)
    {
        return Calendar::with(['events', 'events.attendanceType'])->findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
