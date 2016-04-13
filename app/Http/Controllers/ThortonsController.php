<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ThortonStore;
use DentalSleepSolutions\Http\Requests\ThortonUpdate;
use DentalSleepSolutions\Http\Requests\ThortonDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Thorton;
use DentalSleepSolutions\Contracts\Repositories\Thortons;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ThortonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Thortons $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Thortons $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Thorton $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Thorton $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Thortons $resources
     * @param  \DentalSleepSolutions\Http\Requests\ThortonStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Thortons $resources, ThortonStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Thorton $resource
     * @param  \DentalSleepSolutions\Http\Requests\ThortonUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Thorton $resource, ThortonUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Thorton $resource
     * @param  \DentalSleepSolutions\Http\Requests\ThortonDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Thorton $resource, ThortonDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
