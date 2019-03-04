<?php

namespace App\Repositories;

use App\Echelon;

class EchelonRepo implements RepositoryInterface
{
    public function get()
    {
        return Echelon::get();
    }

    public function find($id)
    {
        return Echelon::findOrFail($id);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
