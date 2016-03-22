<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ChargeStore;
use DentalSleepSolutions\Http\Requests\ChargeUpdate;
use DentalSleepSolutions\Http\Requests\ChargeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Charge;
use DentalSleepSolutions\Contracts\Repositories\Charges;
use Carbon\Carbon;

class ChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Charges $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Charges $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Charge $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Charge $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Charges $resources
     * @param  \DentalSleepSolutions\Http\Requests\ChargeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Charges $resources, ChargeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Charge $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChargeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Charge $resource, ChargeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Charge $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChargeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Charge $resource, ChargeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
