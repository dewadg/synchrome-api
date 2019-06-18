<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use App\Transformers\RoleTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends RestController
{
    protected $transformer_name = RoleTransformer::class;

    /**
     * @SWG\Get(
     *     path="/roles",
     *     tags={"Roles"},
     *     operationId="rolesIndex",
     *     summary="Fetch list of roles.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of roles."
     *     )
     * )
     *
     * @param RoleService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleService $service)
    {
        return $this->sendCollection($service->get());
    }

    /**
     * @SWG\Post(
     *     path="/roles",
     *     tags={"Roles"},
     *     operationId="rolesStore",
     *     summary="Create a new rank.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateRoleRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param RoleService $service
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleService $service, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'accesses' => 'required|array',
        ]);

        try {
            $role = DB::transaction(function () use ($service, $request) {
                return $service->create([
                    'name' => $request->input('name'),
                    'accesses' => $request->input('accesses'),
                ]);
            });

            return $this->sendItem($role, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     operationId="rolesShow",
     *     summary="Fetch list of roles.",
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
     * @param RoleService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RoleService $service, $id)
    {
        try {
            return $this->sendItem($service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Role not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     operationId="rolesUpdate",
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
     *         @SWG\Schema(ref="#/definitions/UpdateRoleRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     )
     * )
     *
     * @param RoleService $service
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleService $service, Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'accesses' => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($service, $request, $id) {
                $service->update($id, [
                    'name' => $request->input('name'),
                    'accesses' => $request->input('accesses'),
                ]);
            });

            return $this->sendItem($service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Role not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     operationId="rolesDestroy",
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
     * @param RoleService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RoleService $service, $id)
    {
        try {
            $service->delete($id);

            return $this->response();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Role not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
