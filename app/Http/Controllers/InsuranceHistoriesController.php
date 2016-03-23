<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceHistoryStore;
use DentalSleepSolutions\Http\Requests\InsuranceHistoryUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsuranceHistory;
use DentalSleepSolutions\Contracts\Repositories\InsuranceHistories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsuranceHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsuranceHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsuranceHistories $resources, InsuranceHistoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsuranceHistory $resource, InsuranceHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsuranceHistory $resource, InsuranceHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
