<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LocationStore;
use DentalSleepSolutions\Http\Requests\LocationUpdate;
use DentalSleepSolutions\Http\Requests\LocationDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Location;
use DentalSleepSolutions\Contracts\Repositories\Locations;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Locations $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Locations $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Location $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Location $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Locations $resources
     * @param  \DentalSleepSolutions\Http\Requests\LocationStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Locations $resources, LocationStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Location $resource
     * @param  \DentalSleepSolutions\Http\Requests\LocationUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Location $resource, LocationUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Location $resource
     * @param  \DentalSleepSolutions\Http\Requests\LocationDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Location $resource, LocationDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
