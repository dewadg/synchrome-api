<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceTypeRepo;
use App\Transformers\AttendanceTypeTransformer;

class AttendanceTypeController extends RestController
{
    protected $transformer_name = AttendanceTypeTransformer::class;

    /**
     * @SWG\Get(
     *     path="/attendance-types",
     *     tags={"AttendanceTypes"},
     *     operationId="attendanceTypesIndex",
     *     summary="Fetch list of attendance types.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of attendance types."
     *     )
     * )
     *
     * @param AttendanceTypeRepo $repo
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AttendanceTypeRepo $repo)
    {
        return $this->sendCollection($repo->get());
    }
}
