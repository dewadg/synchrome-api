<?php

namespace App\Http\Controllers;

use App\Services\RankService;
use App\Transformers\RankTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Swagger\Annotations as SWG;

class RankController extends RestController
{
    protected $transformer_name = RankTransformer::class;

    /**
     * @SWG\Get(
     *     path="/ranks",
     *     tags={"Ranks"},
     *     operationId="ranksIndex",
     *     summary="Fetch list of ranks.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of ranks."
     *     )
     * )
     *
     * @param RankService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RankService $service)
    {
        return $this->sendCollection($service->get());
    }

    /**
     * @SWG\Post(
     *     path="/ranks",
     *     tags={"Ranks"},
     *     operationId="ranksStore",
     *     summary="Create a new rank.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateRankRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param RankService $service
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @SWG\Get(
     *     path="/ranks/{id}",
     *     tags={"Ranks"},
     *     operationId="ranksShow",
     *     summary="Fetch list of ranks.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A rank."
     *     )
     * )
     *
     * @param RankService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RankService $service, $id)
    {
        try {
            return $this->sendItem($service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Rank not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/ranks/{id}",
     *     tags={"Ranks"},
     *     operationId="ranksUpdate",
     *     summary="Update a rank.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateRankRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     )
     * )
     *
     * @param RankService $service
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @SWG\Delete(
     *     path="/ranks/{id}",
     *     tags={"Ranks"},
     *     operationId="ranksDestroy",
     *     summary="Delete a rank.",
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
     * @param RankService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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
