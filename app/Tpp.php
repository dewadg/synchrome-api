<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tpp
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateTppRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="value",
 *         type="number"
 *     ),
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateTppRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="value",
 *         type="number"
 *     ),
 * )
 */
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
