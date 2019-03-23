<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Echelon
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateEchelonRequest",
 *     @SWG\Property(
 *         property="id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="echelon_type_id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="supervisor_id",
 *         type="string"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateEchelonRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="echelon_type_id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="supervisor_id",
 *         type="string"
 *     )
 * )
 */
class Echelon extends Model
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
        'echelon_type_id',
        'supervisor_id',
        'name',
    ];

    /**
     * This echelon's type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(EchelonType::class, 'echelon_type_id');
    }

    /**
     * This echelon's supervisor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor()
    {
        return $this->belongsTo(self::class, 'supervisor_id');
    }

    /**
     * This echelon's subs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subordinates()
    {
        return $this->hasMany(self::class, 'supervisor_id');
    }
}
