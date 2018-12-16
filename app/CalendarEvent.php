<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Calendar
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateCalendarEventRequest",
 *     @SWG\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="start",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="end",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="attendanceTypeId",
 *         type="string"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateCalendarEventRequest",
 *     @SWG\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="start",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="end",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="attendanceTypeId",
 *         type="string"
 *     )
 * )
 */
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
        'title',
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
