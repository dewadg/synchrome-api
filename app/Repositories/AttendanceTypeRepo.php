<?php

namespace App\Repositories;

use App\AttendanceType;

class AttendanceTypeRepo implements RepositoryInterface
{
    public function get()
    {
        return AttendanceType::get(['id', 'name']);
    }

    public function find($id)
    {
        return AttendanceType::findOrFail($id);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
