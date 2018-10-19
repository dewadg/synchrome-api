<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Returns all models.
     *
     * @return Collection
     */
    public function get();

    /**
     * Returns single model by ID.
     *
     * @param $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function find($id);

    /**
     * Deletes a model by ID.
     *
     * @param $id
     * @return boolean
     */
    public function delete($id);
}
