<?php

namespace App\Repositories;

use App\User;

class UserRepo implements RepositoryInterface
{
    public function get()
    {
        return User::with('role')->get();
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
