<?php

namespace App\Services;

use App\Asn;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

class AsnService
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
     * Returns all ASNs.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Store new ASN.
     *
     * @param array $data
     * @return Asn
     */
    public function create(array $data)
    {
        return Asn::create([
            'id' => $data['id'],
            'agency_id' => $data['agency_id'],
            'rank_id' => $data['rank_id'],
            'echelon_id' => $data['echelon_id'],
            'tpp_id' => $data['tpp_id'],
            'workshift_id' => $data['workshift_id'],
            'calendar_id' => $data['calendar_id'],
            'pin' => $data['pin'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
    }

    /**
     * Returns ASN by ID.
     *
     * @param $id
     * @return Asn
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates ASN.
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $asn = $this->repo->find($id);

        return $asn->update([
            'agency_id' => $data['agency_id'],
            'rank_id' => $data['rank_id'],
            'echelon_id' => $data['echelon_id'],
            'tpp_id' => $data['tpp_id'],
            'workshift_id' => $data['workshift_id'],
            'calendar_id' => $data['calendar_id'],
            'pin' => $data['pin'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
    }

    /**
     * Deletes ASN by ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
