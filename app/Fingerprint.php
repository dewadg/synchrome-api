<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fingerprint
 * @package App
 *
 * @SWG\Definition(
 *     definition="RegisterFingerprintRequest",
 *     @SWG\Property(
 *         property="idx",
 *         type="integer"
 *     ),
 *     @SWG\Property(
 *         property="algVer",
 *         type="integer"
 *     ),
 *     @SWG\Property(
 *         property="template",
 *         type="string"
 *     )
 * )
 */
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
