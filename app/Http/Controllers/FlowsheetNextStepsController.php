<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FlowsheetNextStepStore;
use DentalSleepSolutions\Http\Requests\FlowsheetNextStepUpdate;
use DentalSleepSolutions\Http\Requests\FlowsheetNextStepDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\FlowsheetNextStep;
use DentalSleepSolutions\Contracts\Repositories\FlowsheetNextSteps;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FlowsheetNextStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetNextSteps $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FlowsheetNextSteps $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetNextStep $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FlowsheetNextStep $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetNextSteps $resources
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetNextStepStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FlowsheetNextSteps $resources, FlowsheetNextStepStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetNextStep $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetNextStepUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FlowsheetNextStep $resource, FlowsheetNextStepUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetNextStep $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetNextStepDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FlowsheetNextStep $resource, FlowsheetNextStepDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
