<?php

namespace App\Http\Controllers;

use App\Services\EchelonService;
use App\Transformers\EchelonTransformer;
use App\Transformers\EchelonTypeTransformer;

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
}
