<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Workshift
 * @package App
 *
 *
 * @SWG\Definition(
 *     definition="CreateWorkshiftRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *          property="details",
 *          type="array",
 *          @SWG\Items(
 *              @SWG\Property(
 *                  property="index",
 *                  type="integer"
 *              ),
 *              @SWG\Property(
 *                  property="check_in",
 *                  type="string"
 *              ),
 *              @SWG\Property(
 *                  property="check_out",
 *                  type="string"
 *              ),
 *              @SWG\Property(
 *                  property="active",
 *                  type="boolean"
 *              )
 *          )
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateWorkshiftRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *          property="details",
 *          type="array",
 *          @SWG\Items(
 *              @SWG\Property(
 *                  property="index",
 *                  type="integer"
 *              ),
 *              @SWG\Property(
 *                  property="check_in",
 *                  type="string"
 *              ),
 *              @SWG\Property(
 *                  property="check_out",
 *                  type="string"
 *              ),
 *              @SWG\Property(
 *                  property="active",
 *                  type="boolean"
 *              )
 *          )
 *     )
 * )
 */

class Workshift extends Model
{
    use SoftDeletes;

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
     * Date-casted attributes.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * This workshift details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(WorkshiftDetail::class);
    }
}
