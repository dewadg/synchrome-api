<?php

namespace App\Repositories;

use App\Agency;

class AgencyRepo implements RepositoryInterface
{
    public function get()
    {
        return Agency::with('head')->get();
    }

    public function find($id)
    {
        return Agency::with('head')->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
