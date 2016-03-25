<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PlaceServiceStore;
use DentalSleepSolutions\Http\Requests\PlaceServiceUpdate;
use DentalSleepSolutions\Http\Requests\PlaceServiceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PlaceService;
use DentalSleepSolutions\Contracts\Repositories\PlaceServices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PlaceServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PlaceServices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PlaceServices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PlaceService $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PlaceService $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PlaceServices $resources
     * @param  \DentalSleepSolutions\Http\Requests\PlaceServiceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlaceServices $resources, PlaceServiceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\PlaceService $resource
     * @param  \DentalSleepSolutions\Http\Requests\PlaceServiceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PlaceService $resource, PlaceServiceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PlaceService $resource
     * @param  \DentalSleepSolutions\Http\Requests\PlaceServiceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PlaceService $resource, PlaceServiceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
