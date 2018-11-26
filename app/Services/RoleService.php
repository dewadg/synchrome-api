<?php

namespace App\Services;

use App\Repositories\AccessRepo;
use App\Repositories\RoleRepo;
use App\Role;
use Illuminate\Support\Collection;

class RoleService
{
    /**
     * @var RoleRepo
     */
    protected $repo;

    /**
     * @var AccessRepo
     */
    protected $access_repo;

    /**
     * RoleService constructor.
     */
    public function __construct()
    {
        $this->repo = new RoleRepo;
        $this->access_repo = new AccessRepo;
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
     * Checks whether access ID available.
     *
     * @param $id
     * @return bool
     */
    protected function accessIdExists($id)
    {
        $available_ids = $this->access_repo->get()
            ->map(function ($item) {
                return $item->id;
            });

        return $available_ids->has($id);
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

        $role->accesses()->sync($data['accesses']);

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

        $role->update(['name' => $data['name']]);
        $role->accesses()->sync($data['accesses']);

        return $role;
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