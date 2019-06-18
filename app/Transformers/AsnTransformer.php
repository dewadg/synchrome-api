<?php

namespace App\Transformers;

use App\Asn;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class AsnTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'agency',
        'rank',
        'echelon',
        'tpp',
        'workshift',
        'calendar',
    ];

    /**
     * Transforms the model.
     *
     * @param Asn $asn
     * @return array
     */
    public function transform(Asn $asn)
    {
        return [
            'id' => $asn->id,
            'name' => $asn->name,
            'phone' => $asn->phone,
            'address' => $asn->address,
            'pin' => $asn->pin,
            'createdAt' => $asn->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $asn->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Include Agency.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeAgency(Asn $asn)
    {
        return $this->item($asn->agency, new AgencyTransformer);
    }

    /**
     * Include Rank.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeRank(Asn $asn)
    {
        return $this->item($asn->rank, new RankTransformer);
    }

    /**
     * Include Echelon.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeEchelon(Asn $asn)
    {
        return $this->item($asn->echelon, new EchelonTransformer);
    }

    /**
     * Include Tpp.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeTpp(Asn $asn)
    {
        return $this->item($asn->tpp, new TppTransformer);
    }

    /**
     * Include Workshift.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeWorkshift(Asn $asn)
    {
        return $this->item($asn->workshift, new WorkshiftTransformer);
    }

    /**
     * Include Calendar.
     *
     * @param Asn $asn
     * @return Item
     */
    public function includeCalendar(Asn $asn)
    {
        return $this->item($asn->calendar, new CalendarTransformer);
    }
}
