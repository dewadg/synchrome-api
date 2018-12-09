<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'calendar_id',
        'attendance_type_id',
        'name',
        'start',
        'end',
    ];

    /**
     * Date-casted attributes.
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end',
    ];

    /**
     * Returns this event'sa attendance type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type_id');
    }
}
