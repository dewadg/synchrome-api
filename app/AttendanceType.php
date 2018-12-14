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
        'status',
        'tpp_paid',
        'meal_allowance_paid',
        'manual_input',
    ];

    /**
     * Casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'tpp_paid' => 'boolean',
        'meal_allowance_paid' => 'boolean',
        'manual_input' => 'boolean',
    ];
}
