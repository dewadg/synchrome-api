<?php

namespace App\Transformers;

use App\Echelon;
use League\Fractal\TransformerAbstract;

class EchelonTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Echelon $echelon
     * @return array
     */
    public function transform(Echelon $echelon)
    {
        return [
            'id' => $echelon->id,
            'name' => $echelon->name,
            'type' => [
                'id' => $echelon->type->id,
                'name' => $echelon->type->name,
            ],
        ];
    }
}
