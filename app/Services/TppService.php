<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use App\Tpp;
use Illuminate\Support\Collection;

class TppService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Returns all TPP.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Stores new TPP.
     *
     * @param array $data
     * @return Tpp
     */
    public function create(array $data)
    {
        return Tpp::create([
            'name' => $data['name'],
            'value' => $data['value'],
        ]);
    }

    /**
     * Returns TPP by ID.
     *
     * @param $id
     * @return Tpp
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates TPP.
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $tpp = $this->repo->find($id);

        return $tpp->update([
            'name' => $data['name'],
            'value' => $data['value'],
        ]);
    }

    /**
     * Deletes TPP by ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
