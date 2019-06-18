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
            'createdAt' => $type->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $type->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
