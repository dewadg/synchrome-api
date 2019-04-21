<?php

namespace App\Http\Controllers;

use App\Services\AgencyService;
use App\Transformers\AgencyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AgencyController extends RestController
{
    /**
     * @var string
     */
    protected $transformer_name = AgencyTransformer::class;

    /**
     * @var AgencyService
     */
    protected $service;

    /**
     * @param AgencyService $service
     */
    public function __construct(AgencyService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/agencies",
     *     tags={"Agencies"},
     *     operationId="agenciesIndex",
     *     summary="Fetch list of agencies.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of agencies."
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendCollection($this->service->get());
    }

    /**
     * @SWG\Post(
     *     path="/agencies",
     *     tags={"Agencies"},
     *     operationId="agenciesStore",
     *     summary="Create a new agency.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateAgencyRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|unique:agencies,id',
            'name' => 'required',
            'phone' => 'present',
            'address' => 'present',
        ]);

        try {
            $agency = DB::transaction(function () use ($request) {
                return $this->service->create([
                    'id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
            });

            return $this->sendItem($agency, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     *@SWG\Get(
     *     path="/agencies/{id}",
     *     tags={"Agencies"},
     *     operationId="agenciesShow",
     *     summary="Fetch single agency.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="An agency."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/agencies/{id}",
     *     tags={"Agencies"},
     *     operationId="agenciesUpdate",
     *     summary="Update an agency.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateAgencyRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $this->service->update($id, [
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
            });

            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/agencies/{id}",
     *     tags={"Agencies"},
     *     operationId="agenciesDestroy",
     *     summary="Delete an agency.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $this->service->delete($id);
            });

            return response()->json();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
