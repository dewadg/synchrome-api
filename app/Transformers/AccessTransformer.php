<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Access;

class AccessTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Access $access
     * @return array
     */
    public function transform(Access $access)
    {
        return [
            'id' => $access->id,
            'name' => $access->name,
        ];
    }
}
