<?php

namespace App\Repositories;

use App\Access;

class AccessRepo
{
    public function get()
    {
        return Access::get(['id', 'name']);
    }

    public function find($id)
    {
        return Access::findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}