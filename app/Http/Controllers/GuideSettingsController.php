<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\GuideSettingStore;
use DentalSleepSolutions\Http\Requests\GuideSettingUpdate;
use DentalSleepSolutions\Http\Requests\GuideSettingDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\GuideSetting;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class GuideSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideSettings $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GuideSettings $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSetting $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GuideSetting $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideSettings $resources
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuideSettings $resources, GuideSettingStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSetting $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GuideSetting $resource, GuideSettingUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSetting $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GuideSetting $resource, GuideSettingDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
