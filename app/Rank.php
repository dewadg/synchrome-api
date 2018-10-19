<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];
}
