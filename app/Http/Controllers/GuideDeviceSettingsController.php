<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\GuideDeviceSettingStore;
use DentalSleepSolutions\Http\Requests\GuideDeviceSettingUpdate;
use DentalSleepSolutions\Http\Requests\GuideDeviceSettingDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\GuideDeviceSetting;
use DentalSleepSolutions\Contracts\Repositories\GuideDeviceSettings;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class GuideDeviceSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideDeviceSettings $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GuideDeviceSettings $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDeviceSetting $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GuideDeviceSetting $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideDeviceSettings $resources
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceSettingStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuideDeviceSettings $resources, GuideDeviceSettingStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDeviceSetting $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceSettingUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GuideDeviceSetting $resource, GuideDeviceSettingUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideDeviceSetting $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideDeviceSettingDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GuideDeviceSetting $resource, GuideDeviceSettingDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
