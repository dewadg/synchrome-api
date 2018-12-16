<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Calendar
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateCalendarRequest",
 *     @SWG\Property(
 *         property="name",
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
 *         property="events",
 *         type="array",
 *         @SWG\Items(
 *             type="object",
 *             @SWG\Property(
 *                 property="name",
 *                 type="string"
 *             ),
 *             @SWG\Property(
 *                 property="start",
 *                 type="string"
 *             ),
 *             @SWG\Property(
 *                 property="end",
 *                 type="string"
 *             ),
 *             @SWG\Property(
 *                 property="published",
 *                 type="number"
 *             ),
 *             @SWG\Property(
 *                 property="attendanceTypeId",
 *                 type="string"
 *             )
 *         )
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateCalendarRequest",
 *     @SWG\Property(
 *         property="name",
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
 *         property="published",
 *         type="number"
 *     )
 * )
 */

class Calendar extends Model
{
    use SoftDeletes;
    
    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'start',
        'end',
        'published',
    ];

    /**
     * Casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
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
     * Returns this calendar's events.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
