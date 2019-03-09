<?php

namespace App\Services;

use App\Agency;
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

    /**
     * Creates new agency and returns it.
     *
     * @param array $data
     * @return Agency
     */
    public function create(array $data)
    {
        return Agency::create([
            'id' => $data['id'],
            'head_echelon_id' => isset($data['head_echelon_id']) ? $data['head_echelon_id'] : null,
            'name' => $data['name'],
            'phone' => isset($data['phone']) ? $data['phone'] : null,
            'address' => isset($data['address']) ? $data['address'] : null
        ]);
    }
}
