<?php

namespace App\Transformers;

use App\EchelonType;
use League\Fractal\TransformerAbstract;

class EchelonTypeTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param EchelonType $type
     * @return array
     */
    public function transform(EchelonType $type)
    {
        return [
            'id' => $type->id,
            'name' => $type->name,
        ];
    }
}
