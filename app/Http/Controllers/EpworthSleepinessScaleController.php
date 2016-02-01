<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleStore;
use DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleUpdate;
use DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\EpworthSleepinessScale;
use DentalSleepSolutions\Contracts\Repositories\EpworthSleepinessScale as Epworth;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class EpworthSleepinessScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Epworth $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Epworth $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthSleepinessScale $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EpworthSleepinessScale $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Epworth $resources
     * @param  \DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Epworth $resources, EpworthSleepinessScaleStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthSleepinessScale $resource
     * @param  \DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EpworthSleepinessScale $resource, EpworthSleepinessScaleUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthSleepinessScale $resource
     * @param  \DentalSleepSolutions\Http\Requests\EpworthSleepinessScaleDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EpworthSleepinessScale $resource, EpworthSleepinessScaleDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
