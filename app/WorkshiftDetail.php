<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshiftDetail extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workshift_id',
        'index',
        'check_in',
        'check_out',
        'active',
    ];

    /**
     * Casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];
}
