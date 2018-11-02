<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class AuthController extends RestController
{
    /**
     * @SWG\Post(
     *     path="/auth",
     *     tags={"Auth"},
     *     operationId="authAuthenticate",
     *     summary="Authenticate a user.",
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/AuthRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Access token."
     *     )
     * )
     *
     * @param Request $request
     * @param AuthService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request, AuthService $service)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        try {
            $access_token = $service->authenticate(
                $request->input('name'),
                $request->input('password')
            );

            return $this->response([
               'username' => $access_token->username,
               'password' => $access_token->password,
            ]);
        } catch (InvalidCredentialsException $e) {
            return $this->badRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}