<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AirwayEvaluationStore;
use DentalSleepSolutions\Http\Requests\AirwayEvaluationUpdate;
use DentalSleepSolutions\Http\Requests\AirwayEvaluationDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\AirwayEvaluation;
use DentalSleepSolutions\Contracts\Repositories\AirwayEvaluations;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class AirwayEvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AirwayEvaluations $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AirwayEvaluations $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AirwayEvaluation $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AirwayEvaluation $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AirwayEvaluations $resources
     * @param  \DentalSleepSolutions\Http\Requests\AirwayEvaluationStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AirwayEvaluations $resources, AirwayEvaluationStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\AirwayEvaluation $resource
     * @param  \DentalSleepSolutions\Http\Requests\AirwayEvaluationUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AirwayEvaluation $resource, AirwayEvaluationUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AirwayEvaluation $resource
     * @param  \DentalSleepSolutions\Http\Requests\AirwayEvaluationDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AirwayEvaluation $resource, AirwayEvaluationDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
