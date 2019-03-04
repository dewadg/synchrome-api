<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EchelonType extends Model
{
    /**
     * @var boolean
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];
}
