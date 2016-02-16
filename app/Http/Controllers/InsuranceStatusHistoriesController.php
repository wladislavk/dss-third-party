<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryStore;
use DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsuranceStatusHistory;
use DentalSleepSolutions\Contracts\Repositories\InsuranceStatusHistories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceStatusHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceStatusHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsuranceStatusHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceStatusHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsuranceStatusHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceStatusHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsuranceStatusHistories $resources, InsuranceStatusHistoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceStatusHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsuranceStatusHistory $resource, InsuranceStatusHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceStatusHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceStatusHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsuranceStatusHistory $resource, InsuranceStatusHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
