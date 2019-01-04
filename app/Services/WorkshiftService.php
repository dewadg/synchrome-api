<?php

namespace App\Services;

use App\Repositories\WorkshiftRepo;
use App\Workshift;
use App\WorkshiftDetail;
use Illuminate\Support\Collection;

class WorkshiftService
{
    /**
     * @var WorkshiftRepo
     */
    protected $repo;

    /**
     * WorkshiftService constructor.
     */
    public function __construct()
    {
        $this->repo = new WorkshiftRepo;
    }

    /**
     * Returns all workshifts.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->repo->get();
    }

    /**
     * Creates new workshift.
     *
     * @param array $data
     * @return Workshift
     */
    public function create(array $data)
    {
        $workshift = Workshift::create([
            'name' => $data['name'],
        ]);

        $details = collect($data['details'])->map(function ($item) {
            return new WorkshiftDetail([
                'index' => $item['index'],
                'check_in' => $item['check_in'],
                'check_out' => $item['check_out'],
                'active' => $item['active'],
            ]);
        });

        $workshift->details()->saveMany($details);

        return $workshift;
    }

    /**
     * Returns workshift by ID.
     *
     * @param $id
     * @return Workshift
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Updates a workshift.
     *
     * @param $id
     * @param array $data
     * @return Workshift
     */
    public function update($id, array $data)
    {
        $workshift = $this->find($id);

        $workshift->update([
            'name' => $data['name'],
        ]);

        $details = collect($data['details'])->map(function ($item) {
            return new WorkshiftDetail([
                'index' => $item['index'],
                'check_in' => $item['check_in'],
                'check_out' => $item['check_out'],
                'active' => $item['active'],
            ]);
        });

        $workshift->details->each->delete();
        $workshift->details()->saveMany($details);
        $workshift->load('details');

        return $workshift;
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
