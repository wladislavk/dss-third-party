<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ClaimElectronicStore;
use DentalSleepSolutions\Http\Requests\ClaimElectronicUpdate;
use DentalSleepSolutions\Http\Requests\ClaimElectronicDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ClaimElectronic;
use DentalSleepSolutions\Contracts\Repositories\ClaimsElectronic;
use Carbon\Carbon;

class ClaimsElectronicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimsElectronic $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ClaimsElectronic $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimElectronic $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ClaimElectronic $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimElectronic $resources
     * @param  \DentalSleepSolutions\Http\Requests\ClaimElectronicStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClaimElectronic $resources, ClaimElectronicStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimElectronic $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimElectronicUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClaimElectronic $resource, ClaimElectronicUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimElectronic $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimElectronicDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ClaimElectronic $resource, ClaimElectronicDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
