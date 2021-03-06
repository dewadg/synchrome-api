<?php

namespace App\Http\Controllers;

use App\Services\AsnService;
use App\Services\FingerprintService;
use App\Transformers\AsnTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsnController extends RestController
{
    /**
     * @var string
     */
    protected $transformer_name = AsnTransformer::class;

    /**
     * @var AsnService
     */
    protected $service;

    /**
     * @var FingerprintService
     */
    protected $fingerprint_service;

    /**
     * AsnController Constructor.
     *
     * @param AsnService $service
     */
    public function __construct(AsnService $service, FingerprintService $fingerprint_service)
    {
        parent::__construct();

        $this->service = $service;
        $this->fingerprint_service = $fingerprint_service;
    }

    /**
     * @SWG\Get(
     *     path="/asn",
     *     tags={"ASN"},
     *     operationId="asnIndex",
     *     summary="Fetch list of ASNs.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of ASNs."
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
     *     path="/asn",
     *     tags={"ASN"},
     *     operationId="asnStore",
     *     summary="Create a new ASN.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateAsnRequest")
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
            'id' => 'required|unique:asn,id',
            'agencyId' => 'required',
            'rankId' => 'required',
            'echelonId' => 'required',
            'tppId' => 'required',
            'workshiftId' => 'required',
            'calendarId' => 'required',
            'pin' => 'required|unique:asn,pin',
            'name' => 'required',
            'phone' => 'present',
            'address' => 'present',
        ]);

        try {
            $asn = DB::transaction(function () use ($request) {
                return $this->service->create([
                    'id' => $request->input('id'),
                    'agency_id' => $request->input('agencyId'),
                    'rank_id' => $request->input('rankId'),
                    'echelon_id' => $request->input('echelonId'),
                    'tpp_id' => $request->input('tppId'),
                    'workshift_id' => $request->input('workshiftId'),
                    'calendar_id' => $request->input('calendarId'),
                    'pin' => $request->input('pin'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
            });

            return $this->sendItem($asn);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/asn/{id}",
     *     tags={"ASN"},
     *     operationId="asnShow",
     *     summary="Fetch a ASN.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A ASN."
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
            return $this->notFoundResponse('ASN not found');
        }
    }

    /**
     * @SWG\Patch(
     *     path="/asn/{id}",
     *     tags={"ASN"},
     *     operationId="asnUpdate",
     *     summary="Update ASN.",
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
     *         @SWG\Schema(ref="#/definitions/UpdateAsnRequest")
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
            'agencyId' => 'required',
            'rankId' => 'required',
            'echelonId' => 'required',
            'tppId' => 'required',
            'workshiftId' => 'required',
            'calendarId' => 'required',
            'name' => 'required',
            'phone' => 'present',
            'address' => 'present',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $this->service->update($id, [
                    'agency_id' => $request->input('agencyId'),
                    'rank_id' => $request->input('rankId'),
                    'echelon_id' => $request->input('echelonId'),
                    'tpp_id' => $request->input('tppId'),
                    'workshift_id' => $request->input('workshiftId'),
                    'calendar_id' => $request->input('calendarId'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
            });

            return $this->sendItem($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('ASN not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/asn/{id}",
     *     tags={"ASN"},
     *     operationId="asnDestroy",
     *     summary="Delete a ASN.",
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
            return $this->notFoundResponse('ASN not found');
        }
    }

    /**
     * @SWG\Post(
     *     path="/asn/{id}/fingerprints",
     *     tags={"ASN"},
     *     operationId="asnRegisterFingerprint",
     *     summary="Register new fingerprint.",
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
     *         @SWG\Schema(ref="#/definitions/RegisterFingerprintRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     )
     * )
     *
     * @param Request $request
     * @param $id
     * @return Illuminate\Http\JsonResponse
     */
    public function registerFingerprint(Request $request, $id)
    {
        $this->validate($request, [
            'idx' => 'required',
            'algVer' => 'required',
            'template' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $this->fingerprint_service->register($id, [
                    'idx' => $request->input('idx'),
                    'alg_ver' => $request->input('algVer'),
                    'template' => $request->input('template'),
                ]);
            });

            return response()->json();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('ASN not found');
        }
    }

    /**
     * @SWG\Get(
     *     path="/asn/{asn_id}/fingerprints/{fingerprint_id}",
     *     tags={"ASN"},
     *     operationId="asnDestroyFingerprint",
     *     summary="Delete a fingerprint",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="asn_id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="fingerprint_id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Deleted."
     *     )
     * )
     *
     * @param $asn_id
     * @param $fingerprint_id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroyFingerprint($asn_id, $fingerprint_id)
    {
        try {
            DB::transaction(function () use ($asn_id, $fingerprint_id) {
                $this->fingerprint_service->delete($asn_id, $fingerprint_id);
            });

            return response()->json();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('ASN not found');
        }
    }
}
