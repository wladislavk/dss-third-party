<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\GagReflexStore;
use DentalSleepSolutions\Http\Requests\GagReflexUpdate;
use DentalSleepSolutions\Http\Requests\GagReflexDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\GagReflex;
use DentalSleepSolutions\Contracts\Repositories\GagReflexes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class GagReflexesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GagReflexes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GagReflexes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GagReflex $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GagReflex $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\GagReflexes $resources
     * @param  \DentalSleepSolutions\Http\Requests\GagReflexStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GagReflexes $resources, GagReflexStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\GagReflex $resource
     * @param  \DentalSleepSolutions\Http\Requests\GagReflexUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GagReflex $resource, GagReflexUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\GagReflex $resource
     * @param  \DentalSleepSolutions\Http\Requests\GagReflexDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GagReflex $resource, GagReflexDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
