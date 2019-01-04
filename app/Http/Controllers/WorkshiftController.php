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

    public function index(WorkshiftService $service)
    {
        return $this->sendCollection($service->get());
    }

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
