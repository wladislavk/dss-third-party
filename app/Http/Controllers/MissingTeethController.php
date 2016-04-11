<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\MissingToothStore;
use DentalSleepSolutions\Http\Requests\MissingToothUpdate;
use DentalSleepSolutions\Http\Requests\MissingToothDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\MissingTooth;
use DentalSleepSolutions\Contracts\Repositories\MissingTeeth;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class MissingTeethController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\MissingTeeth $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MissingTeeth $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\MissingTooth $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MissingTooth $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\MissingTeeth $resources
     * @param  \DentalSleepSolutions\Http\Requests\MissingToothStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MissingTeeth $resources, MissingToothStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\MissingTooth $resource
     * @param  \DentalSleepSolutions\Http\Requests\MissingToothUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MissingTooth $resource, MissingToothUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\MissingTooth $resource
     * @param  \DentalSleepSolutions\Http\Requests\MissingToothDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MissingTooth $resource, MissingToothDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
