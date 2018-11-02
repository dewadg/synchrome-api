<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class Rank
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateRankRequest",
 *     @SWG\Property(
 *         property="id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateRankRequest",
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     )
 * )
 */
class Rank extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];
}
