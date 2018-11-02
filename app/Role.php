<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * This role's accesses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accesses()
    {
        return $this->belongsToMany(Access::class);
    }
}