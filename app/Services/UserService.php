<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use App\User;

class UserService
{
    /**
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * UserService constructor.
     */
    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Returns all users.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Creates new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => app('hash')->make($data['password']),
            'full_name' => $data['full_name'],
            'role_id' => $data['role_id'],
        ]);
    }

    /**
     * Returns a user by ID.
     *
     * @param $id
     * @return User
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates a user.
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);

        return $user->update([
            'name' => $data['name'],
            'full_name' => $data['full_name'],
            'role_id' => $data['role_id'],
        ]);
    }

    /**
     * Deletes a user by ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
