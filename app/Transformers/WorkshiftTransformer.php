<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use App\Workshift;

class WorkshiftTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'details',
    ];

    /**
     * Transforms the model.
     *
     * @param Workshift $workshift
     * @return array
     */
    public function transform(Workshift $workshift)
    {
        return [
            'id' => $workshift->id,
            'name' => $workshift->name,
            'createdAt' => $workshift->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $workshift->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Include details.
     *
     * @param Workshift $workshift
     * @return Collection
     */
    public function includeDetails(Workshift $workshift)
    {
        return $this->collection($workshift->details, new WorkshiftDetailTransformer);
    }
}
