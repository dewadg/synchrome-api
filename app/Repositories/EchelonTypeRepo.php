<?php

namespace App\Repositories;

use App\EchelonType;

class EchelonTypeRepo implements RepositoryInterface
{
    public function get()
    {
        return EchelonType::get();
    }

    public function find($id)
    {
        return EchelonType::findOrFail($id);
    }

    public function delete()
    {
        return $this->find($id)->delete();
    }
}
