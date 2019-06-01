<?php

namespace App\Transformers;

use App\Agency;
use League\Fractal\TransformerAbstract;

class AgencyTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Agency $agency
     * @return array
     */
    public function transform(Agency $agency)
    {
        return [
            'id' => $agency->id,
            'name' => $agency->name,
            'phone' => $agency->phone,
            'address' => $agency->address,
            'createdAt' => $agency->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $agency->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
