<?php

namespace App\Http\Controllers;

use App\Services\RankService;
use App\Transformers\RankTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankController extends RestController
{
    protected $transformer_name = RankTransformer::class;

    public function index(RankService $service)
    {
        return $this->sendCollection($service->get());
    }

    public function store(RankService $service, Request $request)
    {
        $this->validate($request, [
            'id' => 'required|unique:ranks,id',
            'name' => 'required'
        ]);

        try {
            $rank = $service->create([
                'id' => $request->input('id'),
                'name' => $request->input('name'),
            ]);

            return $this->sendItem($rank, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    public function show(RankService $service, $id)
    {
        try {
            return $this->sendItem($service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Rank not found');
        }
    }

    public function update(RankService $service, Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        try {
            $rank = $service->find($id);

            DB::transaction(function () use (&$rank, $request) {
                $rank->name = $request->input('name');
                $rank->save();
            });

            return $this->sendItem($rank);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Rank not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    public function destroy(RankService $service, $id)
    {
        try {
            $service->delete($id);

            return $this->response();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Rank not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
