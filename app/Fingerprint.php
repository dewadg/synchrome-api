<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'asn_id',
        'idx',
        'alg_ver',
        'template',
    ];
}
