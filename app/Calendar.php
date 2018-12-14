<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
