<?php

namespace App\Transformers;

use App\AttendanceType;
use League\Fractal\TransformerAbstract;

class AttendanceTypeTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param AttendanceType $attendance_type
     * @return array
     */
    public function transform(AttendanceType $attendance_type)
    {
        return [
            'id' => $attendance_type->id,
            'name' => $attendance_type->name,
            'status' => $attendance_type->status,
            'tppPaid' => $attendance_type->tpp_paid,
            'mealAllowancePaid' => $attendance_type->meal_allowance_paid,
            'manualInput' => $attendance_type->manual_input,
            'createdAt' => $attendance_type->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $attendance_type->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
