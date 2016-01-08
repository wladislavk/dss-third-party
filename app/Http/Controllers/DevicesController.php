<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\DeviceStore;
use DentalSleepSolutions\Http\Requests\DeviceUpdate;
use DentalSleepSolutions\Http\Requests\DeviceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Device;
use DentalSleepSolutions\Contracts\Repositories\Devices;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Devices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Devices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Device $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Device $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Devices $resources
     * @param  \DentalSleepSolutions\Http\Requests\DeviceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Devices $resources, DeviceStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Device $resource
     * @param  \DentalSleepSolutions\Http\Requests\DeviceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Device $resource, DeviceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Device $resource
     * @param  \DentalSleepSolutions\Http\Requests\DeviceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Device $resource, DeviceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
