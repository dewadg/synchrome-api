<?php

namespace App\Http\Controllers;

use App\Services\TppService;
use App\Transformers\TppTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TppController extends RestController
{
    /**
     * @var string
     */
    protected $transformer_name = TppTransformer::class;

    /**
     * @var TppService
     */
    protected $service;

    /**
     * TppController Constructor.
     *
     * @param TppService $service
     */
    public function __construct(TppService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/tpp",
     *     tags={"TPP"},
     *     operationId="tppIndex",
     *     summary="Fetch list of TPPs.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of TPPs."
     *     )
     * )
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendCollection($this->service->get());
    }

    /**
     * @SWG\Post(
     *     path="/tpp",
     *     tags={"TPP"},
     *     operationId="tppStore",
     *     summary="Create a new TPP.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateTppRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required|numeric',
        ]);

        try {
            $tpp = DB::transaction(function () use ($request) {
                return $this->service->create([
                    'name' => $request->input('name'),
                    'value' => $request->input('value'),
                ]);
            });

            return $this->sendItem($tpp);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/tpp/{id}",
     *     tags={"TPP"},
     *     operationId="tppShow",
     *     summary="Fetch a TPP.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A TPP."
     *     )
     * )
     *
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('TPP not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/tpp/{id}",
     *     tags={"TPP"},
     *     operationId="tppUpdate",
     *     summary="Update TPP.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateTppRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     )
     * )
     *
     * @param Request $request
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $this->service->update($id, [
                    'name' => $request->input('name'),
                    'value' => $request->input('value'),
                ]);
            });

            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('TPP not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/tpp/{id}",
     *     tags={"TPP"},
     *     operationId="tppDestroy",
     *     summary="Delete a TPP.",
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
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $this->service->delete($id);
            });

            return response()->json();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('TPP not found');
        }
    }
}
