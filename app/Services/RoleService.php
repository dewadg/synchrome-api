<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use App\Role;
use Illuminate\Support\Collection;

class RoleService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * @var RepositoryInterface
     */
    protected $access_repo;

    /**
     * RoleService constructor.
     */
    public function __construct(RepositoryInterface $role_repo, RepositoryInterface $access_repo)
    {
        $this->repo = $role_repo;
        $this->access_repo = $access_repo;
    }

    /**
     * Returns all roles.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Creates a role.
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data)
    {
        $role = Role::create(['name' => $data['name']]);

        if ($data['accesses'] === '*') {
            $accesses = $this->access_repo
                ->get()
                ->map(function ($item) {
                    return $item->id;
                })
                ->all();

            $role->accesses()->sync($accesses);
        } else {
            $role->accesses()->sync($data['accesses']);
        }

        return $role;
    }

    /**
     * Returns a role by ID.
     *
     * @param $id
     * @return Role
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates a role.
     *
     * @param $id
     * @param array $data
     * @return Role
     */
    public function update($id, array $data)
    {
        $role = $this->find($id);

        if (isset($data['accesses']) && $data['accesses'] === '*') {
            $accesses = $this->access_repo
                ->get()
                ->map(function ($item) {
                    return $item->id;
                })
                ->all();

            $role->accesses()->sync($accesses);
        } elseif (isset($data['accesses'])) {
            $role->accesses()->sync($data['accesses']);
        }

        return $role->update(['name' => $data['name']]);
    }

    /**
     * Deletes a role by ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $role = $this->repo->find($id);
        $role->accesses()->detach();

        return $role->delete();
    }
}
