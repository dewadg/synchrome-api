<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class WhoAmITransformer extends TransformerAbstract
{
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
            'role' => [
                'id' => $user->role->id,
                'name' => $user->role->name,
            ],
            'generatedAt' => date('Y-m-d H:i:s'),
        ];
    }
}
