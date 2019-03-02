<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use App\Rank;
use Illuminate\Support\Collection;

class RankService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * RankService constructor.
     */
    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Returns all ranks.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Creates a rank.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Rank::firstOrCreate($data);
    }

    /**
     * Returns rank by ID.
     *
     * @param $id
     * @return Rank
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates a rank.
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $rank = $this->repo->find($id);

        return $rank->update($data);
    }

    /**
     * Deletes rank by ID.
     *
     * @param $id
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
