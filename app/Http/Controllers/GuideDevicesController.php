<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\GuideDeviceStore;
use DentalSleepSolutions\Http\Requests\GuideDeviceUpdate;
use DentalSleepSolutions\Http\Requests\GuideDeviceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\GuideDevice;
use DentalSleepSolutions\Contracts\Repositories\GuideDevices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class GuideDevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideDevices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GuideDevices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDevice $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GuideDevice $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideDevices $resources
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuideDevices $resources, GuideDeviceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDevice $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GuideDevice $resource, GuideDeviceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDevice $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GuideDevice $resource, GuideDeviceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
