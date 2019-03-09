<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

class AgencyService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * @var RepositoryInterface
     */
    protected $echelon_repo;

    /**
     * AgencyService constructor.
     *
     * @param RepositoryInterface $repo
     * @param RepositoryInterface $echelon_repo
     */
    public function __construct(RepositoryInterface $repo, RepositoryInterface $echelon_repo)
    {
        $this->repo = $repo;
        $this->echelon_repo = $echelon_repo;
    }

    /**
     * Returns all agencies.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }
}
