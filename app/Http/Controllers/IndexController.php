<?php

namespace App\Http\Controllers;

use Swagger\Annotations as SWG;

class IndexController extends RestController
{
    /**
     * @SWG\Info(
     *     title="Synchrome API",
     *     version="0.1"
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
}