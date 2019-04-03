<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asn extends Model
{
    use SoftDeletes;

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
