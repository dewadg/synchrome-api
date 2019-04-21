<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends RestController
{
    /**
     * @var string
     */
    protected $transformer_name = UserTransformer::class;

    /**
     * @var UserService
     */
    protected $service;

    /**
     * UserController Constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/users",
     *     tags={"Users"},
     *     operationId="usersIndex",
     *     summary="Fetch list of users.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of users."
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
     *     path="/users",
     *     tags={"Users"},
     *     operationId="usersStore",
     *     summary="Create a new User.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateUserRequest")
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
            'fullName' => 'required',
            'password' => 'required',
            'passwordConf' => 'required|same:password',
            'roleId' => 'required',
        ]);

        try {
            $user = DB::transaction(function () use ($request) {
                return $this->service->create([
                    'name' => $request->input('name'),
                    'full_name' => $request->input('fullName'),
                    'password' => app('hash')->make($request->input('password')),
                    'role_id' => $request->input('roleId'),
                ]);
            });

            return $this->sendItem($user);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     operationId="usersShow",
     *     summary="Fetch a user.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A user."
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
            return $this->notFoundResponse('User not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     operationId="usersUpdate",
     *     summary="Update user.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateUserRequest")
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
            'fullName' => 'required',
            'roleId' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $this->service->update($id, [
                    'name' => $request->input('name'),
                    'full_name' => $request->input('fullName'),
                    'role_id' => $request->input('roleId'),
                ]);
            });

            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('User not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     operationId="usersDestroy",
     *     summary="Delete a user.",
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
            return $this->notFoundResponse('User not found');
        }
    }
}
