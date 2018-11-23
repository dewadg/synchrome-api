<?php

namespace App\Http\Controllers;

use App\Transformers\WhoAmITransformer;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class IndexController extends RestController
{
    /**
     * @SWG\Info(
     *     title="Synchrome API",
     *     version="0.1"
     * )
     *
     * @SWG\SecurityScheme(
     *     securityDefinition="basicAuth",
     *     type="basic",
     *     description="Authenticates via HTTP Basic",
     *     name="authorization"
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->response([
            'name' => 'Synchrome API',
            'version' => 0.1
        ]);
    }

    /**
     *  @SWG\Get(
     *    path="/whoami",
     *    tags={"Who Am I"},
     *    operationId="whoami",
     *    summary="Fetch current logged user.",
     *    security={{"basicAuth":{}}},
     *    @SWG\Response(
     *      response=200,
     *      description="Current logged user."
     *    )
     * )
     *
     * @param Request $request
     * @return void
     */
    public function whoami(Request $request)
    {
        return $this->sendItem($request->user(), WhoAmITransformer::class);
    }
}