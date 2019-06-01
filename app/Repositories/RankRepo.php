<?php

namespace App\Repositories;

use App\Rank;

class RankRepo implements RepositoryInterface
{
    public function get()
    {
        return Rank::get();
    }

    public function find($id)
    {
        return Rank::findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
