<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Rank;

class RankTransformer extends TransformerAbstract
{
    public function transform(Rank $rank)
    {
        return [
            'id' => $rank->id,
            'name' => $rank->name,
        ];
    }
}