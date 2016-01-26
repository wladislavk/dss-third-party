<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\GuideSettingOptionStore;
use DentalSleepSolutions\Http\Requests\GuideSettingOptionUpdate;
use DentalSleepSolutions\Http\Requests\GuideSettingOptionDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\GuideSettingOption;
use DentalSleepSolutions\Contracts\Repositories\GuideSettingOptions;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class GuideSettingOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideSettingOptions $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GuideSettingOptions $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSettingOption $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GuideSettingOption $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GuideSettingOptions $resources
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingOptionStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuideSettingOptions $resources, GuideSettingOptionStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSettingOption $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingOptionUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GuideSettingOption $resource, GuideSettingOptionUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GuideSettingOption $resource
     * @param  \DentalSleepSolutions\Http\Requests\GuideSettingOptionDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GuideSettingOption $resource, GuideSettingOptionDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
