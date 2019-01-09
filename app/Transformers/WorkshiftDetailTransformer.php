<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use App\WorkshiftDetail;

class WorkshiftDetailTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param WorkshiftDetail $detail
     * @return array
     */
    public function transform(WorkshiftDetail $detail)
    {
        return [
            'index' => $detail->index,
            'checkIn' => $detail->check_in,
            'checkOut' => $detail->check_out,
            'active' => $detail->active,
        ];
    }
}
