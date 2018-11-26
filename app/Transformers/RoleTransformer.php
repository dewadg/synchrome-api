<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use App\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'accesses',
    ];

    /**
     * Transforms the model.
     *
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }

    /**
     * Include accesses.
     *
     * @param Role $role
     * @return Collection
     */
    public function includeAccesses(Role $role)
    {
        return $this->collection($role->accesses, new AccessTransformer);
    }
}
