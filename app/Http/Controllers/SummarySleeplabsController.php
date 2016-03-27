<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SummarySleeplabStore;
use DentalSleepSolutions\Http\Requests\SummarySleeplabUpdate;
use DentalSleepSolutions\Http\Requests\SummarySleeplabDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SummarySleeplab;
use DentalSleepSolutions\Contracts\Repositories\SummarySleeplabs;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SummarySleeplabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SummarySleeplabs $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SummarySleeplabs $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SummarySleeplab $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SummarySleeplab $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SummarySleeplabs $resources
     * @param  \DentalSleepSolutions\Http\Requests\SummarySleeplabStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SummarySleeplabs $resources, SummarySleeplabStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SummarySleeplab $resource
     * @param  \DentalSleepSolutions\Http\Requests\SummarySleeplabUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SummarySleeplab $resource, SummarySleeplabUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SummarySleeplab $resource
     * @param  \DentalSleepSolutions\Http\Requests\SummarySleeplabDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SummarySleeplab $resource, SummarySleeplabDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
