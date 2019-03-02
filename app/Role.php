<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateRoleRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="accesses",
 *         type="array",
 *         @SWG\Items(type="number")
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateRoleRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="accesses",
 *         type="array",
 *         @SWG\Items(type="number")
 *     )
 * )
 */
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
