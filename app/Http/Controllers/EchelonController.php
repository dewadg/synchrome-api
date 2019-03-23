<?php

namespace App\Http\Controllers;

use App\Services\EchelonService;
use App\Transformers\EchelonTransformer;
use App\Transformers\EchelonTypeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EchelonController extends RestController
{
    /**
     * @var string
     */
    protected $transformer_name = EchelonTransformer::class;

    /**
     * @var EchelonService
     */
    protected $service;

    public function __construct(EchelonService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/echelon-types",
     *     tags={"Echelons"},
     *     operationId="echelonTypes",
     *     summary="Fetch list of echelon types.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of echelon types."
     *     )
     * )
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function types()
    {
        return $this->sendCollection($this->service->getTypes(), EchelonTypeTransformer::class);
    }

    /**
     * @SWG\Get(
     *     path="/echelons",
     *     tags={"Echelons"},
     *     operationId="echelonIndex",
     *     summary="Fetch list of echelons.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of echelons."
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
     *     path="/echelons",
     *     tags={"Echelons"},
     *     operationId="echelonStore",
     *     summary="Create new echelon.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateEchelonRequest")
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
            'id' => 'required|unique:echelons,id',
            'name' => 'required',
            'echelon_type_id' => 'required',
            'supervisor_id' => 'present',
        ]);

        try {
            $echelon = null;

            DB::transaction(function () use ($request, &$echelon) {
                $echelon = $this->service->create([
                    'id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'echelon_type_id' => $request->input('echelon_type_id'),
                    'supervisor_id' => $request->input('supervisor_id'),
                ]);
            });

            return $this->sendItem($echelon, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/echelons/{id}",
     *     tags={"Echelons"},
     *     operationId="echelonFind",
     *     summary="Fetch echelon by ID.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Echelon with desired ID."
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
            return $this->notFoundResponse('Echelon not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/echelons",
     *     tags={"Echelons"},
     *     operationId="echelonUpdate",
     *     summary="Update new echelon.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateEchelonRequest")
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
        try {
            DB::transaction(function () use ($id, $request) {
                $this->service->update($id, [
                    'name' => $request->input('name'),
                    'echelon_type_id' => $request->input('echelon_type_id'),
                    'supervisor_id' => $request->input('supervisor_id'),
                ]);
            });

            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Echelon not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/echelons",
     *     tags={"Echelons"},
     *     operationId="echelonDestroy",
     *     summary="Delete echelon.",
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
            return $this->notFoundResponse('Echelon not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
