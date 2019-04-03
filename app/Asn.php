<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Asn
 * @package App
 *
 * @SWG\Definition(
 *     definition="CreateAsnRequest",
 *     @SWG\Property(
 *         property="id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="agencyId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="rankId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="echelonId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="tppId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="workshiftId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="calendarId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="pin",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="phone",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="address",
 *         type="string"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateAsnRequest",
 *     @SWG\Property(
 *         property="agencyId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="rankId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="echelonId",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="tppId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="workshiftId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="calendarId",
 *         type="number"
 *     ),
 *     @SWG\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="phone",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="address",
 *         type="string"
 *     )
 * )
 */
class Asn extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'asn';

    /**
     * @var boolean
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'agency_id',
        'rank_id',
        'echelon_id',
        'tpp_id',
        'workshift_id',
        'calendar_id',
        'pin',
        'name',
        'phone',
        'address',
    ];

    /**
     * This ASN's Agency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * This ASN's Rank.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * This ASN's Echelon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function echelon()
    {
        return $this->belongsTo(Echelon::class);
    }

    /**
     * This ASN's Tpp.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tpp()
    {
        return $this->belongsTo(Tpp::class);
    }

    /**
     * This ASN's Workshift.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function workshift()
    {
        return $this->belongsTo(Workshift::class);
    }

    /**
     * This ASN's Calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
