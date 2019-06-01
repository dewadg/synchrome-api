<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Rank;

class RankTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Rank $rank
     * @return array
     */
    public function transform(Rank $rank)
    {
        return [
            'id' => $rank->id,
            'name' => $rank->name,
            'createdAt' => $rank->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $rank->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
