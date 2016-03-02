<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientSummaryStore;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Http\Requests\PatientSummaryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PatientSummary;
use DentalSleepSolutions\Contracts\Repositories\PatientSummaries;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PatientSummariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientSummaries $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PatientSummaries $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientSummary $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PatientSummary $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientSummaries $resources
     * @param  \DentalSleepSolutions\Http\Requests\PatientSummaryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PatientSummaries $resources, PatientSummaryStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientSummary $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientSummaryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientSummary $resource, PatientSummaryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientSummary $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientSummaryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PatientSummary $resource, PatientSummaryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
