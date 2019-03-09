<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
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
        'head_echelon_id',
        'name',
        'phone',
        'address'
    ];

    /**
     * This agency's head echelon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function head()
    {
        return $this->belongsTo(Echelon::class, 'head_echelon_id');
    }
}
