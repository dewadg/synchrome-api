<?php

namespace App\Repositories;

use App\Tpp;

class TppRepo implements RepositoryInterface
{
    public function get()
    {
        return Tpp::get();
    }

    public function find($id)
    {
        return Tpp::findOrFail($id);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
