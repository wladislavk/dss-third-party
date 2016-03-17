<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ScreenerEpworthStore;
use DentalSleepSolutions\Http\Requests\ScreenerEpworthUpdate;
use DentalSleepSolutions\Http\Requests\ScreenerEpworthDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ScreenerEpworth;
use DentalSleepSolutions\Contracts\Repositories\ScreenerEpworth as ScrEpworth;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ScreenerEpworthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ScrEpworth $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ScrEpworth $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ScreenerEpworth $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ScreenerEpworth $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ScrEpworth $resources
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerEpworthStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScrEpworth $resources, ScreenerEpworthStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ScreenerEpworth $resource
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerEpworthUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ScreenerEpworth $resource, ScreenerEpworthUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ScreenerEpworth $resource
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerEpworthDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ScreenerEpworth $resource, ScreenerEpworthDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
