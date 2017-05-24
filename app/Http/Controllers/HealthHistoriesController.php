<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\HealthHistoryStore;
use DentalSleepSolutions\Http\Requests\HealthHistoryUpdate;
use DentalSleepSolutions\Http\Requests\HealthHistoryDestroy;
use DentalSleepSolutions\Contracts\Resources\HealthHistory;
use DentalSleepSolutions\Contracts\Repositories\HealthHistories;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class HealthHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(HealthHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\HealthHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(HealthHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\HealthHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(HealthHistories $resources, HealthHistoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\HealthHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\HealthHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(HealthHistory $resource, HealthHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\HealthHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\HealthHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(HealthHistory $resource, HealthHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * Get health histories by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(HealthHistories $resources, Request $request)
    {
        $fields = $request->input('fields') ?: [];
        $where  = $request->input('where') ?: [];

        $healthHistories = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $healthHistories);
    }
}
