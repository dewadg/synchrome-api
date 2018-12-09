<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceType extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'parent_attendance_type_id',
        'name',
    ];
}
