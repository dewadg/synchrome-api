<?php

namespace App\Http\Controllers;

use App\Services\WorkshiftService;
use App\Transformers\WorkshiftTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkshiftController extends RestController
{
    protected $transformer_name = WorkshiftTransformer::class;

    /**
     * @SWG\Get(
     *     path="/workshifts",
     *     tags={"Workshifts"},
     *     operationId="workshiftsIndex",
     *     summary="Fetch list of workshifts.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of workshifts."
     *     )
     * )
     *
     * @param WorkshiftService $service
     * @return Illuminate\Http\JsonResponse
     */
    public function index(WorkshiftService $service)
    {
        return $this->sendCollection($service->get());
    }

    /**
     * @SWG\Post(
     *     path="/workshifts",
     *     tags={"Workshifts"},
     *     operationId="ranksStore",
     *     summary="Create a new rank.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateWorkshiftRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param WorkshiftService $service
     * @param Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(WorkshiftService $service, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'details' => 'required|array',
            'details.*.index' => 'required|in:1,2,3,4,5,6,7',
            'details.*.check_in' => 'present',
            'details.*.check_out' => 'present',
            'details.*.active' => 'present',
        ]);

        try {
            DB::transaction(function () use ($service, $request, &$workshift) {
                $workshift = $service->create([
                    'name' => $request->input('name'),
                    'details' => $request->input('details'),
                ]);
            });

            return $this->sendItem($workshift, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/workshifts/{id}",
     *     tags={"Workshifts"},
     *     operationId="workshiftsShow",
     *     summary="Fetch workshift by ID.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A workshift."
     *     )
     * )
     *
     * @param WorkshiftService $service
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function find(WorkshiftService $service, $id)
    {
        try {
            $workshift = $service->find($id);

            return $this->sendItem($workshift);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Workshift not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/workshifts/{id}",
     *     tags={"Workshifts"},
     *     operationId="workshiftsUpdate",
     *     summary="Update a workshift.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateWorkshiftRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     )
     * )
     *
     * @param WorkshiftService $service
     * @param Request $request
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function update(WorkshiftService $service, Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'details' => 'required|array',
            'details.*.index' => 'required|in:1,2,3,4,5,6,7',
            'details.*.check_in' => 'present',
            'details.*.check_out' => 'present',
            'details.*.active' => 'present',
        ]);

        try {
            DB::transaction(function () use ($service, $request, $id, &$workshift) {
                $workshift = $service->update($id, [
                    'name' => $request->input('name'),
                    'details' => $request->input('details'),
                ]);
            });

            return $this->sendItem($workshift);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Workshift not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/workshifts/{id}",
     *     tags={"Workshifts"},
     *     operationId="workshiftsUpdate",
     *     summary="Update a workshift.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Deleted."
     *     )
     * )
     *
     * @param WorkshiftService $service
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(WorkshiftService $service, $id)
    {
        try {
            DB::transaction(function () use ($service, $id) {
                $service->delete($id);
            });

            return $this->response();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Workshift not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
