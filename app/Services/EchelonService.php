<?php

namespace App\Services;

use App\Echelon;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

class EchelonService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * @var RepositoryInterface
     */
    protected $echelon_type_repo;

    public function __construct(RepositoryInterface $repo, RepositoryInterface $echelon_type_repo)
    {
        $this->repo = $repo;
        $this->echelon_type_repo = $echelon_type_repo;
    }

    /**
     * Returns all echelons.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Creates an echelon.
     *
     * @param array $data
     * @return Echelon
     */
    public function create(array $data)
    {
        return Echelon::create($data);
    }
}
