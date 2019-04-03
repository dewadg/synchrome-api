<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tpp extends Model
{
    /**
     * @var string
     */
    protected $table = 'tpp';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'value',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'value' => 'double',
    ];
}
