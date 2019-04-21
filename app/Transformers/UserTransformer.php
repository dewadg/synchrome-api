<?php

namespace App\Transformers;

use App\User;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'role',
    ];

    /**
     * Transforms the model.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'fullName' => $user->full_name,
        ];
    }

    /**
     * Returns user's role.
     *
     * @param User $user
     * @return Item
     */
    public function includeRole(User $user)
    {
        return $this->item($user->role, new RoleTransformer);
    }
}
