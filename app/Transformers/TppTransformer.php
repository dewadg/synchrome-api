<?php

namespace App\Transformers;

use App\Tpp;
use League\Fractal\TransformerAbstract;

class TppTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Tpp $tpp
     * @return array
     */
    public function transform(Tpp $tpp)
    {
        return [
            'id' => $tpp->id,
            'name' => $tpp->name,
            'value' => $tpp->value,
        ];
    }
}
