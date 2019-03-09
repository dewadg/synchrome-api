<?php

namespace App\Http\Controllers;

use App\Services\AgencyService;
use App\Transformers\AgencyTransformer;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendCollection($this->service->get());
    }
}
