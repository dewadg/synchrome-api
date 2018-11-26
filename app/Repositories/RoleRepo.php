<?php

namespace App\Repositories;

use App\Role;

class RoleRepo
{
    public function get()
    {
        return Role::with('accesses')->get(['id', 'name']);
    }

    public function find($id)
    {
        return Role::findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}