<?php

namespace App\Repositories;

use App\Asn;

class AsnRepo implements RepositoryInterface
{
    protected $includes = [
        'agency',
        'rank',
        'echelon',
        'tpp',
        'workshift',
        'calendar',
    ];

    public function get()
    {
        return Asn::with($this->includes)->get();
    }

    public function find($id)
    {
        return Asn::with($this->includes)->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
