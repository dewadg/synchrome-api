<?php

namespace App\Repositories;

use App\Workshift;

class WorkshiftRepo implements RepositoryInterface
{
    public function get()
    {
        return Workshift::with('details')->get();
    }

    public function find($id)
    {
        return Workshift::with('details')->findOrFail($id);
    }

    public function delete($id)
    {
        $workshift = $this->find($id);

        return $workshift->delete();
    }
}
